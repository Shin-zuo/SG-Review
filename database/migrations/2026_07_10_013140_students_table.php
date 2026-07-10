<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference_id')->unique(); // External reference ID (e.g. UUID for Xendit)
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            // Student Basic Information
            $table->string('student_name');
            $table->string('student_email');
            $table->string('student_phone');
            $table->string('school_name');
            $table->string('referral_code')->nullable(); // Referral code used during enrollment
            
            // Plan & Status Tracking
            $table->enum('plan_type', ['free_trial', 'premium'])->default('free_trial');
            $table->enum('status', ['pending', 'paid', 'active', 'expired', 'failed', 'cancelled'])->default('pending');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->boolean('is_paid')->default(false);
            
            // Xendit Metadata (For future integration)
            $table->string('xendit_invoice_id')->nullable();
            $table->string('xendit_invoice_url')->nullable();
            $table->string('payment_channel')->nullable(); // e.g., GCASH, PAYMAYA, CREDIT_CARD
            $table->timestamp('paid_at')->nullable();
            
            // Google Classroom Metadata (For future integration)
            $table->boolean('google_classroom_enrolled')->default(false);
            $table->string('google_classroom_invite_id')->nullable();
            $table->timestamp('trial_expires_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
