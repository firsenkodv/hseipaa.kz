<?php

namespace App\Jobs\Form;

use App\Bitrix24\SaveContact;
use App\Mail\Form\ScheduleEnrollMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Support\Traits\EmailAddressCollector;

class ScheduleEnrollJob implements ShouldQueue
{
    use Queueable;
    use EmailAddressCollector;

    public function __construct(public array $data) {}

    public function handle(): void
    {
        SaveContact::make()->save([
            'name'         => $this->data['Имя'],
            'phone'        => $this->data['Телефон'],
            'email'        => $this->data['Email'],
            'type'         => 'individual',
            'organization' => '',
            'extras'       => array_filter([
                'Курс'      => $this->data['Курс']      ?? null,
                'Стоимость' => $this->data['Стоимость'] ?? null,
                'Дата'      => $this->data['Дата']      ?? null,
            ]),
        ]);

        $recipients = $this->emails();

        if (empty($recipients)) {
            return;
        }

        Mail::to($recipients)->send(new ScheduleEnrollMail($this->data));
    }
}
