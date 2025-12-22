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
            ->subject('Expense Alert: ' . $this->expense->cost_type->getLabel())
            ->line('You have a new expense payment alert.')
            ->line('Area: ' . $this->expense->area->getLabel())
            ->line('Amount: ' . $this->expense->currency->name . ' ' . $this->expense->amount)
            ->line('Payment Date: ' . \Carbon\Carbon::parse($this->expense->payment_date)->format('d/m/Y'))
            ->line('Description:')
            ->line($this->expense->description)
            ->line('Sent at: ' . now('America/Costa_Rica')->format('Y-m-d H:i:s T'));
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
