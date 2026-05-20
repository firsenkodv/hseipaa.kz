<?php

namespace App\View\Components\Modules;

use App\Models\News;
use App\Models\Setting;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SliderNews extends Component
{
    public Collection $slides;
    public Collection $newsList;

    public function __construct()
    {
        $homeData = Setting::getGroup('home')->data ?? [];

        $this->slides   = collect($homeData['slider'] ?? [])
            ->filter(fn($s) => !empty($s['img']));

        $this->newsList = News::published()->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.modules.slider_news');
    }
}
