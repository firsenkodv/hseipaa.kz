<?php

namespace App\Mail\Form;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CallMeBlueMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Заявка с сайта — оставьте заявку — мы обсудим ваши цели и подберем решения',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.call_me_blue',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
