<?php

namespace App\View\Components\Schedule;

use App\Models\Schedule;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ScheduleHero extends Component
{
    public function __construct(public Schedule $item)
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.schedule.schedule-hero');
    }
}
