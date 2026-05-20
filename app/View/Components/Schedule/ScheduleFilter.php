<?php

namespace App\View\Components\Schedule;

use App\Models\Schedule;
use App\Models\ScheduleCourse;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ScheduleFilter extends Component
{
    public Collection $courses;
    public string $filterUrl;

    public function __construct()
    {
        $usedIds = Schedule::published()
            ->get(['courses'])
            ->flatMap(fn($s) => collect($s->courses ?? [])->pluck('course_id'))
            ->filter()
            ->map(fn($id) => (int) $id)
            ->unique();

        $this->courses   = ScheduleCourse::ordered()->whereIn('id', $usedIds)->get();
        $this->filterUrl = route('schedule.filter');
    }

    public function render(): View|Closure|string
    {
        return view('components.schedule.schedule-filter');
    }
}
