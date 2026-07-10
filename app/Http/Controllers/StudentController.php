<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Students;
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
            $students = Students::with('course')->latest()->paginate(15);
        } catch (\Exception $e) {
            // Fallback if table not migrated yet
            $students = collect([]);
            Log::warning("Students table query failed (likely not migrated yet): " . $e->getMessage());
        }

        return view('reviewers.students', compact('students'));
    }

    /**
     * Show the enrollment selection & mockup checkout form for a specific course.
     */
    public function showSelection(Course $course)
    {
        return view('pages.enrollment.select', compact('course'));
    }

    /**
     * Store Free Trial mockup submission.
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

        $referenceId = (string) Str::uuid();

        try {
            Students::create([
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
        } catch (\Exception $e) {
            // Log the DB exception gracefully so user can review the mock flow before migrating
            Log::info("Mockup Flow: Could not save student to DB (table not migrated yet): " . $e->getMessage());
        }

        return redirect()->route('enroll.success')->with([
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
                'status' => 'Active',
            ]
        ]);
    }

    /**
     * Store Premium Access mockup submission.
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

        $referenceId = (string) Str::uuid();
        $channel = $validated['payment_channel'] ?? 'GCASH';

        try {
            Students::create([
                'reference_id' => $referenceId,
                'course_id' => $course->id,
                'student_name' => $validated['student_name'],
                'student_email' => $validated['student_email'],
                'student_phone' => $validated['student_phone'],
                'school_name' => $validated['school_name'],
                'referral_code' => $validated['referral_code'] ?? null,
                'plan_type' => 'premium',
                'status' => 'paid', // Mocked as paid right away since Xendit/Google Classroom integration is excluded for mockup review
                'amount' => $course->price,
                'is_paid' => true,
                'payment_channel' => $channel,
                'paid_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::info("Mockup Flow: Could not save student to DB (table not migrated yet): " . $e->getMessage());
        }

        return redirect()->route('enroll.success')->with([
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
                'status' => 'Paid & Confirmed (Mockup)',
            ]
        ]);
    }

    /**
     * Display the mockup success & confirmation page.
     */
    public function success(Request $request)
    {
        $mockData = session('mock_data');

        // Fallback data if user refreshes or accesses /enroll/status/success directly during review
        if (!$mockData) {
            $mockData = [
                'reference_id' => (string) Str::uuid(),
                'plan_type' => 'Premium Reviewer Access (Mockup Preview)',
                'student_name' => 'Juan Dela Cruz (Preview)',
                'student_email' => 'juan.delacruz@sample.edu.ph',
                'school_name' => 'UP Diliman / Sample Branch',
                'referral_code' => 'AGENT-2026',
                'course_title' => 'Civil Service Examination Comprehensive Reviewer',
                'course_acronym' => 'CSE-PRO',
                'google_classroom_id' => 'https://classroom.google.com/c/sample-classroom-invite-code',
                'enrollment_link' => 'https://forms.gle/samplebackupformlink',
                'amount' => 1499.00,
                'payment_channel' => 'GCASH',
                'status' => 'Paid & Confirmed (Mockup)',
            ];
        }

        return view('pages.enrollment.success', compact('mockData'));
    }
}
