<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AttendanceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  string  $dateStr    Y-m-d of the service Sunday
     * @param  string  $dateLabel  Human label e.g. "Sunday, July 19, 2026"
     * @param  array   $payload    keyed by service => ['attendees' => Collection, 'count' => int, 'prev1' => int, 'prev2' => int]
     */
    public function __construct(
        public string $dateStr,
        public string $dateLabel,
        public array $payload,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⛪ WVAC Attendance — ' . $this->dateLabel,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.attendance');
    }
}
