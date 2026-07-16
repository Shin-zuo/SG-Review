<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Services\GoogleClassroomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle incoming Xendit Invoice Webhook (`invoice.paid` callback).
     */
    public function handleXenditInvoice(Request $request)
    {
        $callbackToken = config('services.xendit.callback_token');
        $receivedToken = $request->header('x-callback-token') ?? $request->header('X-CALLBACK-TOKEN');

        // 1. Verify Xendit Callback Signature Token if configured
        if (!empty($callbackToken) && trim((string) $receivedToken) !== trim((string) $callbackToken)) {
            Log::warning("Unauthorized Xendit Webhook signature received.", [
                'expected' => $callbackToken,
                'received' => $receivedToken,
            ]);
            return response()->json(['error' => 'Unauthorized signature'], 401);
        }

        // 2. Extract Data (Support both top-level and nested `data` object from Xendit v2 callbacks)
        $externalId = $request->input('external_id') ?? $request->input('data.external_id') ?? $request->input('id');
        $status = strtoupper((string) ($request->input('status') ?? $request->input('data.status') ?? ''));

        Log::info("Received Xendit Webhook for reference: {$externalId} with status: {$status}");

        if (empty($externalId)) {
            return response()->json(['error' => 'Missing external_id'], 400);
        }

        $student = Students::where('reference_id', $externalId)
            ->orWhere('xendit_invoice_id', $externalId)
            ->first();

        if (!$student) {
            Log::warning("Xendit Webhook: Student record not found for reference ID / invoice ID: {$externalId}");
            return response()->json(['error' => 'Student enrollment not found'], 404);
        }

        // 3. Idempotency Check
        if ($student->is_paid || $student->status === 'paid') {
            Log::info("Idempotency check: Student {$externalId} is already marked as paid.");
            return response()->json(['message' => 'Already processed']);
        }

        // 4. Handle Successful Payment ('PAID' or 'SETTLED')
        if (in_array($status, ['PAID', 'SETTLED'])) {
            $student->update([
                'status' => 'paid',
                'is_paid' => true,
                'paid_at' => now(),
                'payment_channel' => $request->input('payment_channel') ?? $request->input('data.payment_channel', 'GCASH'),
                'xendit_invoice_id' => $request->input('id') ?? $request->input('data.id', $student->xendit_invoice_id),
            ]);

            // 5. Trigger Google Classroom Auto-Invitation
            app(GoogleClassroomService::class)->enrollStudent($student);

            Log::info("Successfully processed payment and triggered Google Classroom invite for {$student->student_email}");
        } elseif (in_array($status, ['EXPIRED', 'FAILED'])) {
            $student->update([
                'status' => strtolower($status),
            ]);
            Log::info("Updated status to {$status} for reference: {$externalId}");
        } else {
            // Proactively double-check Xendit status if status received is unexpected or pending
            app(\App\Services\XenditPaymentService::class)->verifyAndSyncInvoice($student);
        }

        return response()->json(['status' => 'success']);
    }
}
