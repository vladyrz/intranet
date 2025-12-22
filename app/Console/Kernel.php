<?php

namespace App\Console;

use App\Jobs\SendBirthdayEmailJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Dispatch your job daily at 8 AM
        $schedule->job(new SendBirthdayEmailJob())->dailyAt('08:00');
        $schedule->command('campaign:finish')->dailyAt('00:00');

        // Administrative Reminders (Costa Rica 8:00 AM)
        $schedule->command('admin-reminders:dispatch')
            ->dailyAt('08:00')
            ->timezone('America/Costa_Rica');

        // Expense Control Alerts (Same schedule)
        $schedule->command('expense-control:dispatch')
            ->dailyAt('08:00')
            ->timezone('America/Costa_Rica');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
