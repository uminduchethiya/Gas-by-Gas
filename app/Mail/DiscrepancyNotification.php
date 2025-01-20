<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiscrepancyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $deliveryPlan;
    public $note;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($deliveryPlan, $note)
    {
        $this->deliveryPlan = $deliveryPlan;
        $this->note = $note;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Discrepancy Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.discrepancy_notification',
            with: [
                'deliveryPlan' => $this->deliveryPlan,
                'note' => $this->note,
            ],
        );
    }

    
    
    public function attachments(): array
    {
        return [];
    }
}
