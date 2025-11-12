<?php

namespace App\Mail;

use App\Models\RecycleSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyRecyclerMail extends Mailable
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
            view: 'notify-recycler', 
            with: [
                'centerName' => $this->schedule->centerName,
                'customerName' => $this->schedule->customerName,
                'requestDate' => $this->schedule->requestDate,
                'requestTime' => $this->schedule->requestTime,
                'customerPhone' => $this->schedule->customerPhone,
                'customerAddress' => $this->schedule->customerAddress,
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
