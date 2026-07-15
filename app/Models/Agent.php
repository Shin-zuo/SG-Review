<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'facebook_link',
        'address',
        'agent_code',
    ];

    /**
     * Get the students/clients who used this agent's referral code.
     */
    public function referrals()
    {
        return $this->hasMany(Students::class, 'referral_code', 'agent_code');
    }
}
