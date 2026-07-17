<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Agent;
use App\Models\Students;
use Carbon\Carbon;

class HistoricalAnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeds for generating rich historical data across months
     * so that Laravel Charts (Dashboard & Analytics) display vibrant, dynamic graphs.
     */
    public function run(): void
    {
        // Check if sample historical data already exists to avoid duplication
        if (Students::where('student_email', 'like', '%@analytics-sample.test')->exists()) {
            $this->command->info('Historical analytics sample data already exists. Skipping...');
            return;
        }

        $courses = Course::all();
        if ($courses->isEmpty()) {
            $this->command->error('No courses found. Please ensure courses are seeded first.');
            return;
        }

        $cseCourse = $courses->firstWhere('acronym', 'CSE') ?? $courses->first();
        $celeCourse = $courses->firstWhere('acronym', 'CELE') ?? $courses->last();

        // Create sample historical agents/ambassadors if needed
        $agentsData = [
            [
                'name' => 'Maria Santos (Ambassador)',
                'email' => 'maria.santos@analytics-sample.test',
                'phone_number' => '09171234567',
                'address' => 'Manila Hub',
                'agent_code' => 'AMB-MARIA01',
                'facebook_link' => 'https://facebook.com/mariasantos.review',
                'created_at' => Carbon::parse('2026-01-10 10:00:00'),
            ],
            [
                'name' => 'Carlos Reyes (Senior Agent)',
                'email' => 'carlos.reyes@analytics-sample.test',
                'phone_number' => '09189876543',
                'address' => 'Cebu Center',
                'agent_code' => 'AMB-CARLOS02',
                'facebook_link' => 'https://facebook.com/carlosreyes.sg',
                'created_at' => Carbon::parse('2026-02-15 14:30:00'),
            ],
            [
                'name' => 'Elena Cruz (Affiliate)',
                'email' => 'elena.cruz@analytics-sample.test',
                'phone_number' => '09201112233',
                'address' => 'Davao Branch',
                'agent_code' => 'AMB-ELENA03',
                'facebook_link' => 'https://facebook.com/elenacruz.affiliate',
                'created_at' => Carbon::parse('2026-03-05 09:15:00'),
            ]
        ];

        $agentCodes = ['TES-C1USV']; // Include the existing agent code if any
        foreach ($agentsData as $aData) {
            $agent = Agent::firstOrCreate(
                ['agent_code' => $aData['agent_code']],
                $aData
            );
            $agentCodes[] = $agent->agent_code;
        }

        // Generate historical monthly enrollments from January 2026 to June 2026
        // July 2026 already has existing real test data
        $historicalRecords = [
            // January 2026
            [
                'month' => 1, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-MARIA01', 'name' => 'Ana Gomez', 'school' => 'PUP Manila'
            ],
            [
                'month' => 1, 'course' => $cseCourse, 'plan' => 'free_trial', 'status' => 'upgraded', 'amount' => 0.00, 'is_paid' => false,
                'channel' => null, 'agent' => 'AMB-MARIA01', 'name' => 'Bryan Tan', 'school' => 'UST'
            ],
            [
                'month' => 1, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'MAYA', 'agent' => 'AMB-CARLOS02', 'name' => 'Cynthia Lim', 'school' => 'Mapua University'
            ],

            // February 2026
            [
                'month' => 2, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-MARIA01', 'name' => 'David Lee', 'school' => 'FEU'
            ],
            [
                'month' => 2, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'TES-C1USV', 'name' => 'Erica Mendoza', 'school' => 'UP Diliman'
            ],
            [
                'month' => 2, 'course' => $celeCourse, 'plan' => 'free_trial', 'status' => 'upgraded', 'amount' => 0.00, 'is_paid' => false,
                'channel' => null, 'agent' => 'AMB-CARLOS02', 'name' => 'Felix Bautista', 'school' => 'CIT University'
            ],
            [
                'month' => 2, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'BANK_TRANSFER', 'agent' => 'AMB-CARLOS02', 'name' => 'Grace Navarro', 'school' => 'USC Cebu'
            ],

            // March 2026
            [
                'month' => 3, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-MARIA01', 'name' => 'Hannah Ramos', 'school' => 'DLSU'
            ],
            [
                'month' => 3, 'course' => $cseCourse, 'plan' => 'free_trial', 'status' => 'expired', 'amount' => 0.00, 'is_paid' => false,
                'channel' => null, 'agent' => 'AMB-ELENA03', 'name' => 'Ivan Castro', 'school' => 'ADDU'
            ],
            [
                'month' => 3, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-CARLOS02', 'name' => 'Jasmine Cruz', 'school' => 'SLU Baguio'
            ],
            [
                'month' => 3, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'MAYA', 'agent' => 'AMB-ELENA03', 'name' => 'Kenneth Villanueva', 'school' => 'Xavier University'
            ],

            // April 2026
            [
                'month' => 4, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-MARIA01', 'name' => 'Lois Fernandez', 'school' => 'PUP Manila'
            ],
            [
                'month' => 4, 'course' => $cseCourse, 'plan' => 'free_trial', 'status' => 'upgraded', 'amount' => 0.00, 'is_paid' => false,
                'channel' => null, 'agent' => 'TES-C1USV', 'name' => 'Mark Ocampo', 'school' => 'PLM'
            ],
            [
                'month' => 4, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-CARLOS02', 'name' => 'Nino Garcia', 'school' => 'TUP Manila'
            ],
            [
                'month' => 4, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'BANK_TRANSFER', 'agent' => 'AMB-MARIA01', 'name' => 'Olivia Aguilar', 'school' => 'Adamson University'
            ],

            // May 2026
            [
                'month' => 5, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-MARIA01', 'name' => 'Patrick Salazar', 'school' => 'BatStateU'
            ],
            [
                'month' => 5, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'MAYA', 'agent' => 'AMB-ELENA03', 'name' => 'Queen Roxas', 'school' => 'MSU-IIT'
            ],
            [
                'month' => 5, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-CARLOS02', 'name' => 'Rafael Dominguez', 'school' => 'Mapua University'
            ],
            [
                'month' => 5, 'course' => $celeCourse, 'plan' => 'free_trial', 'status' => 'upgraded', 'amount' => 0.00, 'is_paid' => false,
                'channel' => null, 'agent' => 'AMB-CARLOS02', 'name' => 'Sofia Soriano', 'school' => 'USC Cebu'
            ],

            // June 2026
            [
                'month' => 6, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-MARIA01', 'name' => 'Tristan Flores', 'school' => 'UP Diliman'
            ],
            [
                'month' => 6, 'course' => $cseCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 1000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'TES-C1USV', 'name' => 'Ursula Valdes', 'school' => 'UST'
            ],
            [
                'month' => 6, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'MAYA', 'agent' => 'AMB-CARLOS02', 'name' => 'Victor Pascual', 'school' => 'CIT University'
            ],
            [
                'month' => 6, 'course' => $celeCourse, 'plan' => 'premium', 'status' => 'paid', 'amount' => 5000.00, 'is_paid' => true,
                'channel' => 'GCASH', 'agent' => 'AMB-ELENA03', 'name' => 'Wendy Morales', 'school' => 'UM Davao'
            ],
            [
                'month' => 6, 'course' => $celeCourse, 'plan' => 'free_trial', 'status' => 'expired', 'amount' => 0.00, 'is_paid' => false,
                'channel' => null, 'agent' => 'AMB-ELENA03', 'name' => 'Xavier del Rosario', 'school' => 'ADDU'
            ],
        ];

        foreach ($historicalRecords as $index => $rec) {
            $createdDate = Carbon::create(2026, $rec['month'], rand(5, 25), rand(8, 20), rand(10, 50), 0);
            $referenceId = \Illuminate\Support\Str::uuid()->toString();
            
            Students::create([
                'reference_id' => $referenceId,
                'course_id' => $rec['course']->id,
                'student_name' => $rec['name'],
                'student_email' => strtolower(str_replace(' ', '.', $rec['name'])) . '.' . $index . '@analytics-sample.test',
                'student_phone' => '09' . rand(100000000, 999999999),
                'school_name' => $rec['school'],
                'referral_code' => $rec['agent'],
                'plan_type' => $rec['plan'],
                'status' => $rec['status'],
                'amount' => $rec['amount'],
                'is_paid' => $rec['is_paid'],
                'payment_channel' => $rec['channel'],
                'paid_at' => $rec['is_paid'] ? $createdDate->copy()->addMinutes(15) : null,
                'google_classroom_enrolled' => true,
                'google_classroom_invite_id' => 'INV-HIST-' . strtoupper(substr(md5($referenceId), 0, 8)),
                'trial_expires_at' => $rec['plan'] === 'free_trial' ? $createdDate->copy()->addDays(5) : null,
                'created_at' => $createdDate,
                'updated_at' => $createdDate->copy()->addMinutes(20),
            ]);
        }

        $this->command->info('Successfully seeded ' . count($historicalRecords) . ' historical records across Jan-Jun 2026.');
    }
}
