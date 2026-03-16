<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🍪 New Order from ' . $this->data['name'],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.order');
    }

    public function attachments(): array
    {
        return [];
    }
}
