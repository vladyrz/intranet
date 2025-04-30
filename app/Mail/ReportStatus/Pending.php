<?php

namespace App\Mail\ReportStatus;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Pending extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected $ccEmails;

    public function __construct($data)
    {
        $this->data = $data;

        $userRoles = User::role(['ventas'])->pluck('email')->toArray();

        $this->ccEmails = array_unique(array_merge([$this->data['email']], $userRoles));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reporte de cliente pendiente',
            cc: $this->ccEmails,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.report.pending',
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
