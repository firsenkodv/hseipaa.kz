<?php

namespace App\Mail\Form;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecordMeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Заявка на запись — ' . ($this->data['Курс'] ?? 'курс'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.record_me',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
