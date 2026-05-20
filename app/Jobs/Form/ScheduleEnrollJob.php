<?php

namespace App\Jobs\Form;

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
        $recipients = $this->emails();

        if (empty($recipients)) {
            return;
        }

        Mail::to($recipients)->send(new ScheduleEnrollMail($this->data));
    }
}
