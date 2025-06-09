<?php

namespace App\Mail\ReportStatus;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Received extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected $ccEmails;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;

        $userRoles = User::role(['soporte', 'ventas'])
            ->where('email', '!=', $this->data['email'])
            ->pluck('email')
            ->toArray();

        $this->ccEmails = array_unique($userRoles);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reporte de Cliente Recibido',
            cc: $this->ccEmails,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.report.received',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
