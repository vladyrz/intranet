<?php

namespace App\Console\Commands;

use App\Jobs\SendAdminReminderJob;
use App\Models\AdminReminder;
use Illuminate\Console\Command;

class AdminRemindersDispatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin-reminders:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch active administrative reminders that are due for delivery.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // We look for reminders where is_active is true AND next_run_at <= NOW (CR time)
        // Note: next_run_at is stored in DB. We should compare with current time.

        $now = now('America/Costa_Rica');

        $this->info("Checking for reminders due before: " . $now->toDateTimeString());

        $reminders = AdminReminder::query()
            ->where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->where('next_run_at', '<=', $now)
                    ->orWhereNull('next_run_at'); // Should not happen due to boot logic, but safe to include if starts_at passed
            })
            // Extra safety: Don't pick up reminders that "ended"
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->get();

        $count = $reminders->count();
        $this->info("Found {$count} reminders due.");

        foreach ($reminders as $reminder) {
            // Dispatch job
            SendAdminReminderJob::dispatch($reminder);
            $this->info("Dispatched reminder ID: {$reminder->id}");
        }

        return Command::SUCCESS;
    }
}
