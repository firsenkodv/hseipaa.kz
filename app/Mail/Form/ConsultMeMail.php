<?php

namespace App\Mail\Form;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultMeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Заявка с сайта — запрос на консультацию',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.consult_me',
        );
    }
}
