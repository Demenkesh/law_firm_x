<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class Mails extends Mailable
{
    use Queueable, SerializesModels;

    public $mail;
    // protected $output;
    /**
     * Create a new message instance.
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
        $this->subject($mail['subject']);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'MAILS',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
}
