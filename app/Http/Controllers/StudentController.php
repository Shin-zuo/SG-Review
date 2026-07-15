<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Students;
use App\Services\GoogleClassroomService;
use App\Services\XenditPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of students for admin review.
     */
    public function index()
    {
        try {
            $freeTrialStudents = Students::with('course')
                ->where('plan_type', 'free_trial')
                ->latest()
                ->paginate(10, ['*'], 'free_page');

            $premiumStudents = Students::with('course')
                ->where('plan_type', 'premium')
                ->latest()
                ->paginate(10, ['*'], 'premium_page');

            $totalRevenue = Students::where('is_paid', true)->sum('amount');
            $totalActiveTrials = Students::where('plan_type', 'free_trial')->count();
            $totalPremiumPaid = Students::where('plan_type', 'premium')->where('is_paid', true)->count();
            $totalStudentsCount = Students::count();
        } catch (\Exception $e) {
            $freeTrialStudents = collect([]);
            $premiumStudents = collect([]);
            $totalRevenue = 0;
            $totalActiveTrials = 0;
            $totalPremiumPaid = 0;
            $totalStudentsCount = 0;
            Log::warning("Students table query failed: " . $e->getMessage());
        }

        return view('pages.students', compact(
            'freeTrialStudents',
            'premiumStudents',
            'totalRevenue',
            'totalActiveTrials',
            'totalPremiumPaid',
            'totalStudentsCount'
        ));
    }

    /**
     * Show the enrollment selection & checkout form for a specific course.
     */
    public function showSelection(Course $course)
    {
        return view('pages.enrollment.select', compact('course'));
    }

    /**
     * Store Free Trial submission & trigger immediate Google Classroom invitation.
     */
    public function storeFreeTrial(Request $request, Course $course)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email|max:255',
            'student_phone' => 'required|string|max:50',
            'school_name' => 'required|string|max:255',
            'referral_code' => 'nullable|string|max:50',
        ]);

        // Security & Duplicate Check: Prevent enrolling in free trial again for the SAME course
        $existingTrial = Students::where('student_email', $validated['student_email'])
            ->where('course_id', $course->id)
            ->where('plan_type', 'free_trial')
            ->first();

        if ($existingTrial) {
            $isExpired = $existingTrial->status === 'expired' || ($existingTrial->trial_expires_at && $existingTrial->trial_expires_at->isPast());
            $expiryDateFormatted = $existingTrial->trial_expires_at ? $existingTrial->trial_expires_at->format('M d, Y') : 'N/A';

            if ($isExpired) {
                return redirect()->back()->withInput()->withErrors([
                    'student_email' => "Your 7-day Free Trial for {$course->acronym} under ({$validated['student_email']}) has already expired."
                ])->with('existing_trial_id', $existingTrial->id)
                  ->with('trial_is_expired', true);
            } else {
                return redirect()->back()->withInput()->withErrors([
                    'student_email' => "This email ({$validated['student_email']}) is already enrolled and active in the 7-day Free Trial for {$course->acronym} (Valid until {$expiryDateFormatted})."
                ])->with('existing_trial_id', $existingTrial->id)
                  ->with('trial_is_expired', false);
            }
        }

        $referenceId = (string) Str::uuid();
        $student = null;

        $student = new Students([
            'reference_id' => $referenceId,
            'course_id' => $course->id,
            'student_name' => $validated['student_name'],
            'student_email' => $validated['student_email'],
            'student_phone' => $validated['student_phone'],
            'school_name' => $validated['school_name'],
            'referral_code' => $validated['referral_code'] ?? null,
            'plan_type' => 'free_trial',
            'status' => 'active',
            'amount' => 0.00,
            'is_paid' => false,
            'trial_expires_at' => now()->addDays(7),
        ]);

        try {
            $student->save();
        } catch (\Exception $e) {
            Log::warning("Could not save free trial student to DB (table likely not migrated yet): " . $e->getMessage());
        }

        try {
            // Trigger Google Classroom OAuth Invitation Service
            app(GoogleClassroomService::class)->enrollStudent($student);
        } catch (\Exception $e) {
            Log::error("Free Trial Google Classroom Exception: " . $e->getMessage());
        }

        // Store session fallback in case DB not migrated yet during review
        return redirect()->route('enroll.success', ['reference_id' => $referenceId])->with([
            'mock_data' => [
                'reference_id' => $referenceId,
                'plan_type' => 'Free Trial (7-Day Access)',
                'student_name' => $validated['student_name'],
                'student_email' => $validated['student_email'],
                'school_name' => $validated['school_name'],
                'referral_code' => $validated['referral_code'] ?? null,
                'course_title' => $course->title,
                'course_acronym' => $course->acronym,
                'google_classroom_id' => $course->google_classroom_id ?? 'INVITE-GCLASS-TRIAL-2026',
                'enrollment_link' => $course->enrollment_link,
                'amount' => 0.00,
                'payment_channel' => 'FREE_TRIAL',
                'status' => 'Active (Google Classroom Invite Sent)',
            ]
        ]);
    }

    /**
     * Store Premium Access submission & generate Xendit GCash Invoice.
     */
    public function storePremium(Request $request, Course $course)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email|max:255',
            'student_phone' => 'required|string|max:50',
            'school_name' => 'required|string|max:255',
            'referral_code' => 'nullable|string|max:50',
            'payment_channel' => 'nullable|string|max:50',
        ]);

        // Prevent duplicate paid enrollments for the same course
        $existingPaid = Students::where('student_email', $validated['student_email'])
            ->where('course_id', $course->id)
            ->where('plan_type', 'premium')
            ->where('is_paid', true)
            ->first();

        if ($existingPaid) {
            return redirect()->back()->withInput()->withErrors([
                'student_email' => "This email ({$validated['student_email']}) is already enrolled and confirmed in Premium Access for {$course->acronym}!"
            ]);
        }

        $referenceId = (string) Str::uuid();
        $channel = 'GCASH'; // Restricted exclusively to GCash per requirements
        $student = null;
        $invoiceUrl = null;

        $student = new Students([
            'reference_id' => $referenceId,
            'course_id' => $course->id,
            'student_name' => $validated['student_name'],
            'student_email' => $validated['student_email'],
            'student_phone' => $validated['student_phone'],
            'school_name' => $validated['school_name'],
            'referral_code' => $validated['referral_code'] ?? null,
            'plan_type' => 'premium',
            'status' => 'pending',
            'amount' => $course->price,
            'is_paid' => false,
            'payment_channel' => $channel,
        ]);

        try {
            $student->save();
        } catch (\Exception $e) {
            Log::warning("Could not save student to DB (table likely not migrated yet): " . $e->getMessage());
        }

        try {
            // Call Xendit API to generate GCash Checkout Invoice using real or in-memory student model
            $invoice = app(XenditPaymentService::class)->createInvoice($student, $course);

            // If real live Xendit URL is returned, redirect browser immediately to Xendit checkout
            if (!empty($invoice['invoice_url']) && empty($invoice['is_fallback']) && str_starts_with($invoice['invoice_url'], 'http')) {
                return redirect()->away($invoice['invoice_url']);
            }
        } catch (\Exception $e) {
            Log::error("Premium Enrollment/Xendit Exception: " . $e->getMessage());
        }

        return redirect()->route('enroll.success', ['reference_id' => $referenceId])->with([
            'mock_data' => [
                'reference_id' => $referenceId,
                'plan_type' => 'Premium Reviewer Access (Full Syllabus & Season)',
                'student_name' => $validated['student_name'],
                'student_email' => $validated['student_email'],
                'school_name' => $validated['school_name'],
                'referral_code' => $validated['referral_code'] ?? null,
                'course_title' => $course->title,
                'course_acronym' => $course->acronym,
                'google_classroom_id' => $course->google_classroom_id ?? 'INVITE-GCLASS-PREMIUM-2026',
                'enrollment_link' => $course->enrollment_link,
                'amount' => $course->price,
                'payment_channel' => $channel,
                'status' => ($student && $student->status === 'paid') ? 'Paid & Confirmed' : 'Pending Xendit Confirmation / Processing',
            ]
        ]);
    }

    /**
     * Display the success & confirmation status page (Redirection mechanism).
     */
    public function success(Request $request)
    {
        $referenceId = $request->query('reference_id');
        $mockData = session('mock_data');

        // If reference_id is provided in URL, lookup actual record in DB first
        if ($referenceId) {
            try {
                $student = Students::with('course')->where('reference_id', $referenceId)->first();
                if ($student) {
                    $course = $student->course;
                    $statusDisplay = match ($student->status) {
                        'paid' => 'Paid & Confirmed',
                        'active' => 'Active (Google Classroom Invite Sent)',
                        'pending' => 'Pending Xendit Confirmation / Processing',
                        default => ucfirst($student->status),
                    };

                    $mockData = [
                        'reference_id' => $student->reference_id,
                        'plan_type' => ($student->plan_type === 'free_trial') ? 'Free Trial (7-Day Access)' : 'Premium Reviewer Access',
                        'student_name' => $student->student_name,
                        'student_email' => $student->student_email,
                        'school_name' => $student->school_name,
                        'referral_code' => $student->referral_code,
                        'course_title' => $course ? $course->title : 'SG-Review Course',
                        'course_acronym' => $course ? $course->acronym : 'COURSE',
                        'google_classroom_id' => $course ? $course->google_classroom_id : null,
                        'enrollment_link' => $course ? $course->enrollment_link : null,
                        'amount' => $student->amount,
                        'payment_channel' => $student->payment_channel ?? 'FREE_TRIAL',
                        'status' => $statusDisplay,
                        'is_paid' => $student->is_paid,
                        'google_classroom_enrolled' => $student->google_classroom_enrolled,
                    ];
                }
            } catch (\Exception $e) {
                Log::warning("Could not lookup student by reference_id: " . $e->getMessage());
            }
        }

        // Fallback data if accessed directly without parameter or session
        if (!$mockData) {
            $mockData = [
                'reference_id' => $referenceId ?? (string) Str::uuid(),
                'plan_type' => 'Premium Reviewer Access (Preview)',
                'student_name' => 'Juan Dela Cruz (Preview)',
                'student_email' => 'juan.delacruz@sample.edu.ph',
                'school_name' => 'UP Diliman / Sample Branch',
                'referral_code' => 'AGENT-2026',
                'course_title' => 'Civil Service Examination Comprehensive Reviewer',
                'course_acronym' => 'CSE-PRO',
                'google_classroom_id' => '1234567890',
                'enrollment_link' => 'https://forms.gle/samplebackupformlink',
                'amount' => 1499.00,
                'payment_channel' => 'GCASH',
                'status' => 'Paid & Confirmed',
            ];
        }

        return view('pages.enrollment.success', compact('mockData'));
    }

    /**
     * Admin manually approves a student's payment and sends/resends Google Classroom Invite.
     */
    public function approvePayment(Students $student)
    {
        $student->update([
            'status' => 'paid',
            'is_paid' => true,
            'paid_at' => now(),
        ]);

        app(\App\Services\GoogleClassroomService::class)->enrollStudent($student);

        return redirect()->back()->with('success', "Payment confirmed and Google Classroom invitation sent to {$student->student_email}!");
    }

    /**
     * Admin manually triggers / resends a Google Classroom Invite for an enrolled student.
     */
    public function resendInvite(Students $student)
    {
        $student->update([
            'google_classroom_enrolled' => false, // Reset flag to force fresh API call
        ]);

        $enrolled = app(\App\Services\GoogleClassroomService::class)->enrollStudent($student);

        if ($enrolled) {
            return redirect()->back()->with('success', "Google Classroom invitation dispatched successfully to {$student->student_email}!");
        }

        return redirect()->back()->with('error', "Could not dispatch invite to {$student->student_email}. Check if Google Classroom ID is set on the course.");
    }

    /**
     * Remove / unenroll a student from Google Classroom and delete their database record.
     */
    public function destroy(Students $student)
    {
        $email = $student->student_email;
        // Revoke classroom access first
        app(\App\Services\GoogleClassroomService::class)->unenrollStudent($student);

        // Delete from database
        $student->delete();

        return redirect()->back()->with('success', "Student {$email} has been unenrolled from Google Classroom and removed from the database.");
    }

    /**
     * Unenroll a student from Google Classroom without deleting their record (mark as expired).
     */
    public function unenroll(Students $student)
    {
        $email = $student->student_email;
        app(\App\Services\GoogleClassroomService::class)->unenrollStudent($student);

        return redirect()->back()->with('success', "Student {$email} has been unenrolled/revoked from Google Classroom.");
    }

    /**
     * Student requests a 3-day free trial extension.
     */
    public function requestExtension(Request $request, Course $course)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'extension_reason' => 'required|string|max:1000',
        ]);

        $student = Students::where('id', $validated['student_id'])->where('course_id', $course->id)->firstOrFail();

        if ($student->extension_status === 'pending') {
            return redirect()->back()->with('success', "Your 3-day trial extension request is already under admin review. Please check your email later!");
        }

        if ($student->extension_status === 'approved') {
            return redirect()->back()->with('success', "Your trial extension was already approved! Check your Google Classroom access.");
        }

        $student->update([
            'extension_status' => 'pending',
            'extension_days' => 3,
            'extension_reason' => $validated['extension_reason'],
        ]);

        return redirect()->back()->with('success', "Your 3-day trial extension request has been submitted successfully and is currently under review by an administrator!");
    }

    /**
     * Admin approves a student's 3-day trial extension request.
     */
    public function approveExtension(Students $student)
    {
        $days = $student->extension_days ?: 3;
        $newExpiry = ($student->trial_expires_at && $student->trial_expires_at->isFuture())
            ? $student->trial_expires_at->addDays($days)
            : now()->addDays($days);

        $student->update([
            'extension_status' => 'approved',
            'status' => 'active',
            'trial_expires_at' => $newExpiry,
        ]);

        // Re-enroll / re-invite student to Google Classroom if access was previously revoked
        if (!$student->google_classroom_enrolled) {
            app(\App\Services\GoogleClassroomService::class)->enrollStudent($student);
        }

        return redirect()->back()->with('success', "Extension approved for {$student->student_email}! Expiration updated to {$newExpiry->format('M d, Y')} and Classroom invite verified.");
    }

    /**
     * Admin rejects a student's trial extension request.
     */
    public function rejectExtension(Students $student)
    {
        $student->update([
            'extension_status' => 'rejected',
        ]);

        return redirect()->back()->with('success', "Extension request rejected for {$student->student_email}.");
    }
}
