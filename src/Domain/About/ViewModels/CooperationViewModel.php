<?php

namespace Domain\About\ViewModels;

use App\Models\Setting;
use Illuminate\Support\Fluent;
use Support\Traits\Makeable;

class CooperationViewModel
{
    use Makeable;

    public function getPageData(): Fluent
    {
        return new Fluent(Setting::getGroup('sotrudnichestvo')->data ?? []);
    }
}
