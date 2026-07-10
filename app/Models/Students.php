<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'course_id',
        'student_name',
        'student_email',
        'student_phone',
        'school_name',
        'referral_code',
        'plan_type',
        'status',
        'amount',
        'is_paid',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'payment_channel',
        'paid_at',
        'google_classroom_enrolled',
        'google_classroom_invite_id',
        'trial_expires_at',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'google_classroom_enrolled' => 'boolean',
        'paid_at' => 'datetime',
        'trial_expires_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
