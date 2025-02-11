<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GasCylinderPriceUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $gasCylinders;
    public $role;

    public function __construct($gasCylinders, $role)
    {
        $this->gasCylinders = $gasCylinders;
        $this->role = $role;
    }

    public function build()
    {
        return $this->subject('Updated Gas Cylinder Prices')
            ->view('emails.gas_cylinder_price_update')
            ->with([
                'gasCylinders' => $this->gasCylinders,
                'role' => $this->role,
            ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Gas Cylinder Price Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.gas_cylinder_price_update',
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
