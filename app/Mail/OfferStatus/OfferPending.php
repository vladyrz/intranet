<?php

namespace App\Mail\OfferStatus;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfferPending extends Mailable
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

        $userRoles = User::role(['soporte', 'ventas', 'servicio_al_cliente', 'gerente'])->pluck('email')->toArray();

        $this->ccEmails = array_unique(array_merge([$this->data['email']], $userRoles));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Oferta Pendiente',
            cc: $this->ccEmails,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.offer.pending',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->data['attachments'] ?? [] as $filePath) {
            $attachments[] = Attachment::fromPath($filePath);
        }

        return $attachments;
    }
}
