<?php

namespace App\View\Components\Modules;

use App\Models\News;
use App\Models\Setting;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SliderNews extends Component
{
    public Collection $slides;
    public Collection $newsList;

    public function __construct()
    {
        $homeData = Setting::getGroup('home')->data ?? [];

        $this->slides = collect($homeData['slider'] ?? [])
            ->filter(fn($s) => !empty($s['img_desktop']))
            ->map(fn($s) => (object) [
                'bg'        => Storage::url($s['img_desktop']),
                'bg_mobile' => !empty($s['img_mobile']) ? Storage::url($s['img_mobile']) : null,
                'href'      => $s['href'] ?? null,
                'tag'       => !empty($s['href']) ? 'a' : 'div',
                'title'     => $s['заголовок'] ?? null,
                'desc'      => $s['описание'] ?? null,
                'html'      => $s['html'] ?? null,
            ]);

        $this->newsList = News::published()->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.modules.slider_news');
    }
}
