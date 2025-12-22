<?php

namespace App\Jobs;

use App\Enums\ExpenseStatus;
use App\Models\ExpenseControl;
use App\Models\User;
use App\Notifications\ExpenseControlNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendExpenseControlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ExpenseControl $expense)
    {
    }

    public function handle(): void
    {
        $timezone = 'America/Costa_Rica';

        try {
            // Validations
            if ($this->expense->status !== ExpenseStatus::Active) {
                return;
            }

            // Get target users (RRHH or Ventas roles)
            // Assuming Spatie Permission is used or a similar role system.
            // Requirement: "Solo usuarios con roles rrhh y ventas"

            $usersToNotify = User::role(['rrhh', 'ventas'])->get();

            if ($usersToNotify->isEmpty()) {
                Log::warning("ExpenseControl ID {$this->expense->id}: No users found with roles 'rrhh' or 'ventas' to notify.");
            } else {
                Notification::send($usersToNotify, new ExpenseControlNotification($this->expense));
            }

            // Success Updates
            $this->expense->last_sent_at = now($timezone);
            $this->expense->failure_count = 0;
            $this->expense->last_error_message = null;
            $this->expense->last_error_trace = null;

            // Calculate Next Run
            $this->expense->next_run_at = $this->expense->calculateNextRunAt();

            // Should we update payment_date for next occurrence? 
            // AdminReminder updates next_run_at.
            // For Expenses, payment_date acts as the visible date.
            // If it's recurrent, we should probably update payment_date similarly to next_run_at
            // so the user sees "Next Payment Date".

            if ($this->expense->next_run_at) {
                // If next_run_at was calculated (meaning it's future), we can sync payment_date to that day
                $this->expense->payment_date = $this->expense->next_run_at->toDateString();
            }

            $this->expense->save();

        } catch (\Throwable $e) {
            // Error Logic
            $this->expense->failure_count++;
            $this->expense->last_error_message = $e->getMessage();
            $this->expense->last_error_trace = $e->getTraceAsString();
            $this->expense->last_failed_at = now($timezone);
            $this->expense->save();

            Log::error("Failed to send ExpenseControl ID {$this->expense->id}: " . $e->getMessage());

            $this->fail($e);
        }
    }
}
