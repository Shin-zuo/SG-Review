<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Students;
use App\Services\GoogleClassroomService;
use Illuminate\Support\Facades\Log;

class ExpireFreeTrials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:expire-trials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically check and unenroll/expire 7-day Free Trial students whose time has ended';

    /**
     * Execute the console command.
     */
    public function handle(GoogleClassroomService $classroomService)
    {
        $this->info('Checking for expired Free Trial enrollments...');

        $expiredStudents = Students::where('plan_type', 'free_trial')
            ->where('status', 'active')
            ->whereNotNull('trial_expires_at')
            ->where('trial_expires_at', '<=', now())
            ->get();

        if ($expiredStudents->isEmpty()) {
            $this->info('No expired trials found today.');
            return Command::SUCCESS;
        }

        $count = 0;
        foreach ($expiredStudents as $student) {
            $this->info("Revoking access for: {$student->student_email} (Expired: {$student->trial_expires_at})");
            
            try {
                $classroomService->unenrollStudent($student);
                $count++;
            } catch (\Exception $e) {
                $this->error("Failed to unenroll {$student->student_email}: " . $e->getMessage());
                Log::error("ExpireFreeTrials exception for {$student->student_email}: " . $e->getMessage());
            }
        }

        $this->info("Successfully expired and revoked {$count} free trial students from Google Classroom.");
        return Command::SUCCESS;
    }
}
