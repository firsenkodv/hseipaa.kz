<?php

namespace Domain\Schedule\ViewModels;

use App\Models\Schedule;
use App\Models\Setting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;
use Support\Traits\Makeable;

class ScheduleViewModel
{
    use Makeable;

    public function getPageData(): Fluent
    {
        return new Fluent(Setting::getGroup('schedule')->data ?? []);
    }

    public function getPublished(): LengthAwarePaginator
    {
        return Schedule::published()->paginate(config('site.constants.paginate'));
    }

    public function getBySlug(string $slug): Schedule
    {
        return Schedule::published()->where('slug', $slug)->firstOrFail();
    }
}
