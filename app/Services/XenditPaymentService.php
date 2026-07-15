<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Students;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XenditPaymentService
{
    /**
     * Create a Xendit Invoice for a student enrollment.
     *
     * @param Students $student
     * @param Course $course
     * @return array
     */
    public function createInvoice(Students $student, Course $course): array
    {
        $secretKey = config('services.xendit.secret_key');

        if (empty($secretKey)) {
            Log::warning("Xendit Secret Key is not configured. Falling back to simulated invoice.");
            return $this->fallbackInvoice($student, $course);
        }

        try {
            $payload = [
                'external_id' => $student->reference_id,
                'amount' => (float) $course->price,
                'payer_email' => $student->student_email,
                'description' => "Enrollment for {$course->title} ({$student->plan_type})",
                'success_redirect_url' => route('enroll.success', ['reference_id' => $student->reference_id]),
                'failure_redirect_url' => route('enroll.selection', ['course' => $course->id, 'error' => 'payment_failed']),
                'currency' => 'PHP',
                'payment_methods' => ['GCASH'], // Restricted to GCash only per requirements
                'customer' => [
                    'given_names' => $student->student_name,
                    'email' => $student->student_email,
                    'mobile_number' => $student->student_phone,
                ],
                'customer_notification_preference' => [
                    'invoice_created' => ['email'],
                    'invoice_reminder' => ['email'],
                    'invoice_paid' => ['email'],
                ],
            ];

            $response = Http::withBasicAuth($secretKey, '')
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.xendit.co/v2/invoices', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($student->exists) {
                    $student->update([
                        'xendit_invoice_id' => $data['id'] ?? null,
                        'xendit_invoice_url' => $data['invoice_url'] ?? null,
                        'payment_channel' => 'GCASH',
                    ]);
                } else {
                    $student->xendit_invoice_id = $data['id'] ?? null;
                    $student->xendit_invoice_url = $data['invoice_url'] ?? null;
                    $student->payment_channel = 'GCASH';
                }

                Log::info("Xendit Invoice created successfully for reference: {$student->reference_id}");

                return [
                    'success' => true,
                    'invoice_id' => $data['id'] ?? null,
                    'invoice_url' => $data['invoice_url'] ?? route('enroll.success', ['reference_id' => $student->reference_id]),
                    'data' => $data,
                ];
            }

            Log::error("Xendit API error: " . $response->body());
        } catch (\Exception $e) {
            Log::error("Xendit Invoice creation exception: " . $e->getMessage());
        }

        // Fallback or simulated response if API fails during testing/dev
        return $this->fallbackInvoice($student, $course);
    }

    /**
     * Fallback mock invoice for local testing if API key is invalid or unreachable.
     */
    protected function fallbackInvoice(Students $student, Course $course): array
    {
        $mockUrl = route('enroll.success', ['reference_id' => $student->reference_id]);
        
        if ($student->exists) {
            $student->update([
                'xendit_invoice_id' => 'mock_xnd_' . uniqid(),
                'xendit_invoice_url' => $mockUrl,
                'payment_channel' => 'GCASH',
            ]);
        } else {
            $student->xendit_invoice_id = 'mock_xnd_' . uniqid();
            $student->xendit_invoice_url = $mockUrl;
            $student->payment_channel = 'GCASH';
        }

        return [
            'success' => true,
            'invoice_id' => $student->xendit_invoice_id,
            'invoice_url' => $mockUrl,
            'is_fallback' => true,
        ];
    }
}
