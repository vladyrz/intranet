<?php

namespace App\Notifications;

use App\Models\AdminReminderPlus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public AdminReminderPlus $reminder)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Administrative Reminder: ' . $this->reminder->type->getLabel())
            ->line('You have a new administrative reminder.')
            ->line('Type: ' . $this->reminder->type->getLabel())
            ->line('Frequency: ' . $this->reminder->frequency->getLabel())
            ->line('Content:')
            ->line($this->reminder->content)
            ->line('Sent at: ' . now('America/Costa_Rica')->format('Y-m-d H:i:s T'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'admin_reminder_id' => $this->reminder->id,
            'type' => $this->reminder->type->value,
            'content' => $this->reminder->content,
            'sent_at' => now(),
        ];
    }
}
