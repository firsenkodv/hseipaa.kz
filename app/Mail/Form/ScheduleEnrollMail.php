<?php

namespace App\Mail\Form;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScheduleEnrollMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Заявка с сайта — запись на курс',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.schedule_enroll',
        );
    }
}
