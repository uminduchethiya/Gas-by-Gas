<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loginUrl;

   
    public function __construct($user, $loginUrl)
    {
        $this->user = $user;
        $this->loginUrl = $loginUrl;
    }

    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Gas by Gas',
        );
    }

    
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_created',
            with: [
                'user' => $this->user,
                'loginUrl' => $this->loginUrl,
            ],
        );
    }

   
    public function attachments(): array
    {
        return [];
    }
}
