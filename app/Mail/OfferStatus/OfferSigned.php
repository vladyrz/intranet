<?php

namespace App\Mail\OfferStatus;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfferSigned extends Mailable
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

        // Cargar los correos a CC en el constructor
        $userRoles = User::role(['soporte', 'ventas', 'servicio_al_cliente', 'gerente', 'contabilidad'])
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
            subject: 'Oferta Firmada',
            cc: $this->ccEmails,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.offer.signed',
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
