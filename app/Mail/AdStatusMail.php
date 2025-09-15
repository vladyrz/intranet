<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected string $status; // pending, scheduled, stopped, finished

    /**
     * Create a new message instance.
     */
    public function __construct(array $data, string $status)
    {
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjects = [
            'pending' => 'Solicitud de pauta pendiente',
            'scheduled' => 'Pauta programada',
            'stopped' => 'Pauta detenida',
            'finished' => 'Pauta finalizada',
        ];

        return new Envelope(
            subject: $subjects[$this->status] ?? 'Actualización de solicitud de pauta',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.adStatus',
            with: [
                'status' => $this->status,
            ]
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
