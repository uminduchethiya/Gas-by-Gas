<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTokenStatusChangeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tokenId;
    public $tokenCode;
    public $newStatus;
    public $Reasone;


    public function __construct($user, $tokenId, $tokenCode, $newStatus,$reason)
    {
        $this->user = $user;
        $this->tokenId = $tokenId;
        $this->tokenCode = $tokenCode;
        $this->newStatus = $newStatus;
        $this->Reasone = $reason;

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Gas Token Status Has Changed!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.token_notification',
            with: [
                'user' => $this->user,
                'tokenId' => $this->tokenId,
                'tokenCode' => $this->tokenCode,
                'newStatus' => $this->newStatus,
                'Reasone'=>$this->Reasone
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
