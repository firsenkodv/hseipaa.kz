<?php

namespace App\Jobs\Form;

use App\Bitrix24\SaveContact;
use App\Mail\Form\RecordMeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Support\Traits\EmailAddressCollector;

class RecordMeJob implements ShouldQueue
{
    use Queueable;
    use EmailAddressCollector;

    public function __construct(public array $data) {}

    public function handle(): void
    {
        $isLegal = ($this->data['Тип'] ?? '') === 'Юридическое лицо';

        SaveContact::make()->save([
            'name'         => $this->data['ФИО'],
            'phone'        => $this->data['Телефон'],
            'email'        => $this->data['Email'],
            'type'         => $isLegal ? 'company' : 'individual',
            'organization' => $isLegal ? ($this->data['Компания'] ?? '') : '',
        ]);

        $recipients = $this->emails();

        if (empty($recipients)) {
            return;
        }

        Mail::to($recipients)->send(new RecordMeMail($this->data));
    }
}
