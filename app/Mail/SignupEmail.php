<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignupEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Email subject
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Our Platform 🚀',
        );
    }

    /**
     * Email body (view)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.signup', 
            with: [
                'data' => $this->data
            ]
        );
    }

    /**
     * Attachments (optional)
     */
    public function attachments(): array
    {
        return [];
    }
}
