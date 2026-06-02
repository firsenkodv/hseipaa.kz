<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class ChangeContactComposer
{
    public function compose(View $view): void
    {
        $data = Setting::getGroup('social')->data ?? [];

        $view->with([
            'phone'    => $data['phone'] ?? null,
            'whatsapp' => $data['whatsapp'] ?? null,
            'telegram' => $data['telegram'] ?? null,
        ]);
    }
}
