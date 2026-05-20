<?php

namespace App\View\Components\Socials;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Socials extends Component
{
    public array $social;
    public string $btnClass;

    public function __construct(string $btnClass = 'social-btn')
    {
        $this->btnClass = $btnClass;
        $this->social   = Setting::getGroup('social')->data ?? [];
    }

    public function render(): View|Closure|string
    {
        return view('components.socials.socials');
    }
}
