<?php

namespace App\Notifications;

use App\Models\ExpenseControl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpenseControlNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public ExpenseControl $expense)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Alerta de Gasto: ' . $this->expense->cost_type->getLabel())
            ->line('Tienes una nueva alerta de pago.')
            ->line('Area: ' . $this->expense->area->getLabel())
            ->line('Monto: ' . $this->expense->currency->name . ' ' . $this->expense->amount)
            ->line('Fecha de Pago: ' . \Carbon\Carbon::parse($this->expense->payment_date)->format('d/m/Y'))
            ->line('Descripción: ' . $this->expense->description)
            ->line('Enviado a las: ' . now('America/Costa_Rica')->format('Y-m-d H:i:s T'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'expense_control_id' => $this->expense->id,
            'cost_type' => $this->expense->cost_type->value,
            'amount' => $this->expense->amount,
            'description' => $this->expense->description,
            'sent_at' => now(),
        ];
    }
}
