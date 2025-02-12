<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTokenExtendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loginUrl;
    public $newExpirationDate;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $loginUrl
     * @param $newExpirationDate
     */
    public function __construct($user, $loginUrl, $newExpirationDate)
    {
        $this->user = $user;
        $this->loginUrl = $loginUrl;
        $this->newExpirationDate = $newExpirationDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Important Update: Token Expiration Extended',
        );
    }

    /**
     * Get the message content.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send_token_extend',
            with: [
                'user' => $this->user,
                'loginUrl' => $this->loginUrl,
                'newExpirationDate' => $this->newExpirationDate,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
