<?php

namespace App\Notifications;

use App\Models\AdminReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public AdminReminder $reminder)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Recordatorio Administrativo: ' . $this->reminder->type->getLabel())
            ->line('Tienes un nuevo recordatorio administrativo.')
            ->line('Tipo: ' . $this->reminder->type->getLabel())
            ->line('Frecuencia: ' . $this->reminder->frequency->getLabel())
            ->line('Contenido:')
            ->line($this->reminder->content)
            ->line('Enviado a las: ' . now('America/Costa_Rica')->format('Y-m-d H:i:s T'));
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
