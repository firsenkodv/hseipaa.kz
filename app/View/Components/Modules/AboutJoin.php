<?php

namespace App\View\Components\Modules;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AboutJoin extends Component
{
    public array $social;

    public function __construct()
    {
        $this->social = Setting::getGroup('social')->data ?? [];
    }

    public function render(): View|Closure|string
    {
        return view('components.modules.about-join');
    }
}
