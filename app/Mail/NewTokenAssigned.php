<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTokenAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Token Assigned to You',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new_token_assigned',
            with: [
                'user' => $this->user,
                'tokenId' => $this->token,
                'loginUrl' => $this->token,

            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
