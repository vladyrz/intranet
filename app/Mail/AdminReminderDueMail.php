<?php

namespace App\Mail;

use App\Models\AdminReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminReminderDueMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public AdminReminder $reminder)
    {
        //
    }

    public function build()
    {
        return $this->subject(__('Recordatorio administrativo'))
            ->markdown('mail.admin_reminder_due', [
                'reminder' => $this->reminder,
                'user'     => $this->reminder->user,
            ]);
    }
}
