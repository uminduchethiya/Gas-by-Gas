<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTokenCreationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tokenId;
    public $cylinderType;
    public $price;
    public $expiresAt;
    public $cylinderCount;

    public function __construct($user, $tokenId, $cylinderType, $price, $expiresAt, $cylinderCount)
    {
        $this->user = $user;
        $this->tokenId = $tokenId;
        $this->cylinderType = $cylinderType;
        $this->price = $price;
        $this->expiresAt = $expiresAt;
        $this->cylinderCount = $cylinderCount;

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Gas Token Has Been Created!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.token_created_notification',
            with: [
                'user' => $this->user,
                'tokenId' => $this->tokenId,
                'cylinderType' => $this->cylinderType,
                'price' => $this->price,
                'expiresAt' => $this->expiresAt,
                'cylinderCount' => $this->cylinderCount,

            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
