<?php

namespace App\Jobs;

use App\Enums\ReminderStatus;
use App\Models\AdminReminderPlus;
use App\Models\AdminReminderRun;
use App\Notifications\AdminReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAdminReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public AdminReminderPlus $reminder)
    {
    }

    public function handle(): void
    {
        $timezone = 'America/Costa_Rica';
        $runStatus = ReminderStatus::Success;
        $errorMsg = null;
        $errorTrace = null;

        try {
            // Verify if still active (double check)
            if (!$this->reminder->is_active) {
                return;
            }

            // Send Notification
            $this->reminder->user->notify(new AdminReminderNotification($this->reminder));

            // Succcess Logic
            $this->reminder->last_sent_at = now($timezone);
            $this->reminder->failure_count = 0;
            $this->reminder->last_error_message = null;
            $this->reminder->last_error_trace = null;

            // Calculate Next Run
            $this->reminder->next_run_at = $this->reminder->calculateNextRunAt();
            $this->reminder->save();

        } catch (\Throwable $e) {
            $runStatus = ReminderStatus::Failed;
            $errorMsg = $e->getMessage();
            $errorTrace = $e->getTraceAsString();

            // Error Logic
            $this->reminder->failure_count++;
            $this->reminder->last_error_message = $errorMsg;
            $this->reminder->last_error_trace = $errorTrace;
            $this->reminder->last_failed_at = now($timezone);
            $this->reminder->save();

            Log::error("Failed to send Admin Reminder ID {$this->reminder->id}: " . $e->getMessage());

            // Error Logic
            $this->reminder->failure_count++;
            $this->reminder->last_error_message = $errorMsg;
            $this->reminder->last_error_trace = $errorTrace;
            $this->reminder->last_failed_at = now($timezone);
            $this->reminder->save();

            Log::error("Failed to send Admin Reminder ID {$this->reminder->id}: " . $e->getMessage());
        }

        AdminReminderRun::create([
            'admin_reminder_id' => $this->reminder->id,
            'run_at' => now($timezone),
            'status' => $runStatus,
            'error_message' => $errorMsg,
            'error_trace' => $errorTrace,
            'channel' => 'mail',
            'job_id' => $this->job?->getJobId(),
        ]);

        if ($runStatus === ReminderStatus::Failed) {
            $this->fail($errorMsg); // This marks the job as failed in Laravel's eye
        }
    }
}
