<?php

namespace App\Mail;

use App\Models\RecycleSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyCustomerMail extends Mailable
{
    use Queueable, SerializesModels;



    public $schedule;

    /**
     * Create a new message instance.
     */
    public function __construct(RecycleSchedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recycle Mate Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'notify-customer', 
            with: [
                'customerName' => $this->schedule->customerName,
                'centerName' => $this->schedule->centerName,
                'collectionDate' => $this->schedule->collectionDate,
                'collectionTime' => $this->schedule->collectionTime,
                'recyclerPhone' => $this->schedule->recyclerPhone,
                'recyclerName' => $this->schedule->recyclerName,
            ]
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
