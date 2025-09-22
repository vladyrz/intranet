<?php
namespace App\Console\Commands;

use App\Mail\AdminReminderDueMail;
use App\Models\AdminReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendAdminReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Envía correos de recordatorios según next_due_at';

    public function handle(): int
    {
        $now = now();
        $count = 0;

        AdminReminder::query()
            ->whereNotNull('next_due_at')
            ->whereDate('next_due_at', $now->toDateString())
            ->chunkById(200, function ($reminders) use (&$count, $now) {
                foreach ($reminders as $reminder) {
                    if (!$reminder->isDueNow($now)) continue;
                    $user = $reminder->user;
                    if (!$user || empty($user->email)) continue;

                    try {
                        Mail::to($user->email)->send(new AdminReminderDueMail($reminder));
                        $reminder->last_sent_at = $now;
                        $reminder->saveQuietly();
                        $reminder->bumpToNextDue();
                        $count++;
                    } catch (\Throwable $e) {
                        Log::error('Reminder mail failed', [
                            'reminder_id' => $reminder->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

        $this->info("Recordatorios enviados: {$count}");
        return Command::SUCCESS;
    }
}
