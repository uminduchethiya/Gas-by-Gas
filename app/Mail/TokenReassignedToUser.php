<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TokenReassignedToUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tokenId;
    public $loginUrl;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $user
     * @param  string  $tokenId
     * @param  string  $loginUrl
     * @return void
     */
    public function __construct($user, $tokenId, $loginUrl)
    {
        $this->user = $user;
        $this->tokenId = $tokenId;
        $this->loginUrl = $loginUrl;
    }

    /**
     * Get the envelope for the message.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Token Has Been Reassigned',
        );
    }

    /**
     * Get the content for the message.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.token_reassigned',
            with: [
                'user' => $this->user,
                'tokenId' => $this->tokenId,
                'loginUrl' => $this->loginUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
