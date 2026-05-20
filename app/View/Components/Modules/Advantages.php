<?php

namespace App\View\Components\Modules;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Advantages extends Component
{
    public string $youtubeVideoId;

    public function __construct()
    {
        $social = Setting::getGroup('social')->data ?? [];
        $this->youtubeVideoId = $social['youtube_video_id'] ?? '9ofghOY94-4';
    }

    public function render(): View|Closure|string
    {
        return view('components.modules.advantages');
    }
}
