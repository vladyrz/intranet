<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccesStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected string $status; // pending, received, sent, approved, rejected

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @param string $status
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
            'pending'  => 'Solicitud de Permiso Pendiente',
            'received' => 'Solicitud de Permiso Recibida',
            'sent'     => 'Solicitud de Permiso Enviada',
            'approved' => 'Solicitud de Permiso Aprobada',
            'rejected' => 'Solicitud de Permiso Rechazada',
        ];

        return new Envelope(
            subject: $subjects[$this->status] ?? 'Actualización de Solicitud de Permiso',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.accesStatus',
            with: [
                'status' => $this->status
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
