<?php

namespace App\View\Components\Menu;

use App\Models\Schedule;
use App\Models\TrainingCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopMenu extends Component
{
    public array $navItems;
    public $trainingCategories;
    public $schedules;

    public function __construct()
    {
        $this->navItems = [
            ['label' => 'Главная',    'route' => 'home',       'pattern' => 'home'],
            ['label' => 'О нас',      'route' => 'about',      'pattern' => 'about*',     'dropdown' => [
                ['label' => 'Команда',        'route' => 'about.team',       'pattern' => 'about.team*'],
                ['label' => 'Клиенты',        'route' => 'about.clients',    'pattern' => 'about.clients*'],
                ['label' => 'Партнёры',       'route' => 'about.partners',   'pattern' => 'about.partners*'],
                ['label' => 'Документы',      'route' => 'about.documents',  'pattern' => 'about.documents*'],
                ['label' => 'О компании',     'route' => 'about.company',    'pattern' => 'about.company*'],
                ['label' => 'Сотрудничество', 'route' => 'about.cooperation','pattern' => 'about.cooperation*'],
            ]],
            ['label' => 'Обучение',   'route' => 'training',   'pattern' => 'training*', 'hasDropdown' => true],
            ['label' => 'Консалтинг', 'route' => 'consulting', 'pattern' => 'consulting*'],
            ['label' => 'Online',     'route' => 'remote',     'pattern' => 'remote*'],
            ['label' => 'Расписание', 'route' => 'schedule',    'pattern' => 'schedule*', 'hasScheduleDropdown' => true],
            ['label' => 'Полезное',   'route' => 'resources',  'pattern' => 'resources*', 'dropdown' => [
                ['label' => 'Законы',    'route' => 'resources.laws',      'pattern' => 'resources.laws*'],
                ['label' => 'Новости',   'route' => 'resources.news',      'pattern' => 'resources.news*'],
                ['label' => 'Важное',    'route' => 'resources.important', 'pattern' => 'resources.important*'],
                ['label' => 'Дипломы',   'route' => 'resources.diplomas',  'pattern' => 'resources.diplomas*'],
                ['label' => 'Семинары',  'route' => 'resources.seminar',   'pattern' => 'resources.seminar*'],
            ]],
            ['label' => 'Контакты',   'route' => 'contacts',   'pattern' => 'contacts*'],
        ];

        $this->trainingCategories = TrainingCategory::with(['trainings' => function ($q) {
            $q->published()->orderBy('sorting');
        }])->orderBy('sorting')->get();

        $this->schedules = Schedule::published()->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.menu.top-menu');
    }
}
