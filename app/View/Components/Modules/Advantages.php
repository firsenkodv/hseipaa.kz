<?php

namespace App\View\Components\Modules;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Advantages extends Component
{
    public string $youtubeVideoId;
    public string $h2;
    public string $advDesc;
    public array $advCards;
    public string $rulesLink;

    public function __construct(?array $home = [])
    {
        $home   = $home ?? [];
        $social = Setting::getGroup('social')->data ?? [];
        $this->youtubeVideoId = $social['youtube_video_id'] ?? '9ofghOY94-4';
        $this->h2       = $home['home_adv_h2']        ?? 'Преимущества Высшей Школы Экономики';
        $this->advDesc  = $home['home_adv_desc']       ?? '25 лет на рынке профессионального образования. Международные стандарты обучения. Самое лучшее качество по приемлемым ценам.';
        $this->advCards = $home['home_adv_cards']      ?? [
            ['value' => 'Лучшие',        'text' => 'образовательные программы. Участвуем в международных и отечественных программах по повышению квалификации работников финансовой системы'],
            ['value' => '27 000',        'text' => 'довольных клиентов окончившие наши курсы отзываются положительно как о качестве преподавания так и об объёме полученных знаний и информации'],
            ['value' => '25 лет',        'text' => 'успешного опыта и стабильная положительная репутация по праву дают нам возможность называться одним из самых сильных образовательных учреждений'],
            ['value' => 'Самое крупное', 'text' => 'образовательное учреждение работа во всех регионах Казахстана и ближнего зарубежья проведение корпоративных семинаров, обучение в группах'],
        ];
        $this->rulesLink = $home['home_adv_rules_link'] ?? '#';
    }

    public function render(): View|Closure|string
    {
        return view('components.modules.advantages');
    }
}
