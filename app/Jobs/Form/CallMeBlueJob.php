<?php

namespace App\Jobs\Form;

use App\Bitrix24\SaveContact;
use App\Mail\Form\CallMeBlueMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Support\Traits\EmailAddressCollector;

class CallMeBlueJob implements ShouldQueue
{
    use Queueable;
    use EmailAddressCollector;

    public function __construct(public array $data) {}

    public function handle(): void
    {
        SaveContact::make()->save([
            'name'         => $this->data['ФИО'],
            'phone'        => $this->data['Телефон'],
            'email'        => $this->data['Email'],
            'type'         => 'individual',
            'organization' => '',
        ]);

        $recipients = $this->emails();

        if (empty($recipients)) {
            return;
        }

        Mail::to($recipients)->send(new CallMeBlueMail($this->data));
    }
}
