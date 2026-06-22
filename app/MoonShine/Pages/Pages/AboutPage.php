<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Pages;

use App\Models\Setting;
use Illuminate\Http\Request;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Enums\ToastType;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Json;
use App\Enums\Pages\PageTemplate;
use App\Enums\Resources\TeaserTemplate;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class AboutPage extends Page
{
    public function getTitle(): string
    {
        return 'О нас';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup('onas');
    }

    #[AsyncMethod]
    public function store(Request $request): JsonResponse
    {
        $setting = $this->getSetting();
        $setting->data = $request->except(['_token', '_method']);
        $setting->save();

        return JsonResponse::make()->toast('Сохранено', ToastType::SUCCESS);
    }

    private function form(): FormBuilder
    {
        return FormBuilder::make()
            ->asyncMethod('store')
            ->fill($this->getSetting()->data ?? [])
            ->fields([
                Box::make([
                    Tabs::make([
                        Tab::make('Основное', [
                            ID::make('ID'),
                            Grid::make([
                                Column::make([
                                    Box::make([
                                        Text::make('Заголовок', 'title')->required()->unescape(),
                                        Text::make('Для меню', 'menu_title')->unescape(),
                                        Textarea::make('Краткое описание', 'short_desc')->unescape(),
                                    ]),
                                ])->columnSpan(9),

                                Column::make([
                                    Box::make([
                                        Divider::make('Статус публикации'),
                                        Switcher::make('Опубликовано', 'published')->default(1),
                                        Divider::make('Шаблон вывода'),
                                        Select::make('Шаблон', 'page_template')
                                            ->options(PageTemplate::toOptions())
                                            ->default(PageTemplate::Default->value),
                                        Divider::make('Шаблон внутренних страниц'),
                                        Select::make('Анонс', 'section_template')
                                            ->options(TeaserTemplate::toOptions())
                                            ->default(TeaserTemplate::Default->value),
                                    ]),
                                ])->columnSpan(3),
                            ]),

                            Collapse::make('Баннер', [
                                Text::make('Заголовок (h1)', 'banner_title')
                                    ->default('Добро пожаловать в наш образовательный центр!'),
                                Textarea::make('Подзаголовок', 'banner_subtitle')
                                    ->default('мы занимаемся профессиональной подготовкой и повышением квалификации специалистов в области экономики и финансов.'),
                                Text::make('Кнопка 1 (текст)', 'banner_btn1')
                                    ->default('Начать обучение'),
                                Text::make('Кнопка 2 (текст)', 'banner_btn2')
                                    ->default('Получить консультацию'),
                                Textarea::make('Цитата', 'banner_quote')
                                    ->default('Наша миссия — предоставить качественное образование, соответствующее современным требованиям рынка труда и международным стандартам.'),
                                Text::make('Автор — имя', 'banner_author_name')
                                    ->default('Дмитрий Фирсенко'),
                                Text::make('Автор — должность', 'banner_author_role')
                                    ->default('Генеральный директор Центра Образования'),
                            ]),

                        ])->icon('document-text'),

                        Tab::make('Блоки', [
                            Collapse::make('Преимущества (advantages)', [
                                Json::make('', 'advantages')
                                    ->fields([
                                        Text::make('Цифра / значение', 'number'),
                                        Text::make('Описание', 'text'),
                                    ])
                                    ->default([
                                        ['number' => '5 000+',  'text' => 'обучающихся ежегодно проходят обучение'],
                                        ['number' => '12 000+', 'text' => 'выпускников за весь период работы'],
                                        ['number' => '50+',     'text' => 'программ обучения и сертификации'],
                                        ['number' => '200+',    'text' => 'компаний-партнеров доверяют нам обучение'],
                                        ['number' => '98%',     'text' => 'трудоустройство выпускников в первый год'],
                                        ['number' => '16 лет',  'text' => 'на рынке опыт и надежность'],
                                    ])
                                    ->vertical()
                                    ->creatable()
                                    ->removable(),
                            ]),

                            Collapse::make('Наши преимущества (benefits)', [
                                Json::make('', 'benefits')
                                    ->fields([
                                        Text::make('Заголовок', 'title'),
                                        Textarea::make('Описание', 'text'),
                                    ])
                                    ->default([
                                        ['title' => 'Государственная лицензия',    'text' => 'Все программы лицензированы Министерством образования РК. Документы признаются работодателями по всей стране.'],
                                        ['title' => 'Опытные преподаватели',        'text' => 'Команда практикующих экспертов с опытом работы более 10 лет в своих областях. Актуальные знания из реальной практики.'],
                                        ['title' => 'Практическая направленность',  'text' => 'Фокус на практические навыки и реальные кейсы. 70% времени обучения посвящено практическим занятиям.'],
                                        ['title' => 'Гибкий график обучения',       'text' => 'Онлайн, офлайн и смешанные форматы. Вечерние и выходные группы для работающих специалистов.'],
                                        ['title' => 'Индивидуальный подход',        'text' => 'Малые группы до 15 человек. Персональная поддержка куратора на протяжении всего обучения.'],
                                        ['title' => 'Поддержка 24/7',               'text' => 'Техническая поддержка и консультации преподавателей в любое время. Доступ к материалам без ограничений.'],
                                    ])
                                    ->vertical()
                                    ->creatable()
                                    ->removable(),
                            ]),

                            Collapse::make('История (history)', [
                                Text::make('Заголовок блока', 'history_title')
                                    ->default('16 лет на рынке образования'),
                                Textarea::make('Подзаголовок блока', 'history_subtitle')
                                    ->default('Наш путь от небольшого учебного центра до лидера профессионального образования в Казахстане'),
                                Json::make('', 'history_items')
                                    ->fields([
                                        Text::make('Год', 'year'),
                                        Text::make('Заголовок', 'title'),
                                        Textarea::make('Описание', 'text'),
                                    ])
                                    ->default([
                                        ['year' => '2001', 'title' => 'Основание компании',          'text' => 'Начало пути в образовательной сфере. Первые программы по охране труда.'],
                                        ['year' => '2013', 'title' => 'Расширение направлений',      'text' => 'Добавлены программы по пожарной и экологической безопасности.'],
                                        ['year' => '2017', 'title' => 'Государственная аккредитация', 'text' => 'Получена лицензия Министерства образования РК на образовательную деятельность.'],
                                        ['year' => '2020', 'title' => 'Переход на онлайн',            'text' => 'Запуск платформы дистанционного обучения и мобильного приложения.'],
                                        ['year' => '2026', 'title' => 'Настоящее время',              'text' => '16 лет успешной работы, более 12000 выпускников, 50+ программ обучения.'],
                                    ])
                                    ->vertical()
                                    ->creatable()
                                    ->removable(),
                            ]),

                            Collapse::make('Мобильное приложение (app)', [
                                Textarea::make('Заголовок', 'app_title')
                                    ->default("Учитесь в любом месте\nс нашим приложением"),
                                Textarea::make('Описание', 'app_desc')
                                    ->default('Скачайте мобильное приложение и получите полный доступ к образовательной платформе прямо со своего смартфона. Учитесь в удобное время, где бы вы ни находились.'),
                                Text::make('Ссылка App Store', 'app_store_url')->default('#'),
                                Text::make('Ссылка Google Play', 'app_google_url')->default('#'),
                            ]),
                        ])->icon('squares-2x2'),

                        Tab::make('Медиа', [
                            Grid::make([
                                Column::make([
                                    Divider::make('НЕ пишите заголовок h1 в описании'),
                                    TinyMce::make('Описание', 'desc'),
                                ])->columnSpan(12),
                            ]),
                        ])->icon('photo'),

                        Tab::make('SEO', [
                            Text::make('Мета-заголовок', 'metatitle')->unescape(),
                            Text::make('Мета-описание', 'description')->unescape(),
                            Text::make('Ключевые слова', 'keywords')->unescape(),
                            Textarea::make('Скрипт', 'script')->unescape(),
                        ])->icon('magnifying-glass'),

                        Tab::make('Дополнительно', [
                            Column::make([
                                Collapse::make('Вопрос/Ответ', [
                                    Json::make('', 'faq')->fields([
                                        Text::make('Заголовок', 'title'),
                                        Json::make('Опции', 'options')->fields([
                                            Textarea::make('Вопрос', 'question'),
                                            TinyMce::make('Ответ', 'answer'),
                                        ])->vertical()->creatable(limit: 50)->removable(),
                                    ])->vertical()->creatable(limit: 1)->removable(),
                                ]),
                            ]),
                        ])->icon('adjustments-horizontal'),
                    ]),
                ]),
            ])
            ->submit('Сохранить', ['class' => 'btn-primary']);
    }

    protected function components(): iterable
    {
        yield $this->form();
    }
}
