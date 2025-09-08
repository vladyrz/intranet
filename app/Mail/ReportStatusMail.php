<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected string $status; // pending, received, approved, rejected

    /**
     * Create a new message instance.
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
            'pending' => 'Reporte de cliente pendiente',
            'received' => 'Reporte de cliente recibido',
            'approved' => 'Reporte de cliente aprobado',
            'rejected' => 'Reporte de cliente rechazado',
        ];

        return new Envelope(
            subject: $subjects[$this->status] ?? 'Actualización de reporte de cliente',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.reportStatus',
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
