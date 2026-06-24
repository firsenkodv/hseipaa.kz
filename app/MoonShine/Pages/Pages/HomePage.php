<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Pages;

use App\Models\Setting;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Laravel\TypeCasts\ModelCaster;
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
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class HomePage extends Page
{
    public function getTitle(): string
    {
        return 'Главная';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup('home');
    }

    #[AsyncMethod]
    public function store(): JsonResponse
    {
        $this->form()->apply(fn(Setting $item) => $item->save());

        return JsonResponse::make()->toast('Сохранено', ToastType::SUCCESS);
    }

    private function form(): FormBuilder
    {
        return FormBuilder::make()
            ->asyncMethod('store')
            ->fillCast($this->getSetting(), new ModelCaster(Setting::class))
            ->fields([
                Box::make([
                    Tabs::make([
                        Tab::make('Основное', [
                            ID::make('ID'),
                            Grid::make([
                                Column::make([
                                    Box::make([
                                        Text::make('Заголовок', 'title')->required()->unescape(),
                                    ]),
                                ])->columnSpan(9),

                                Column::make([
                                    Box::make([
                                        Divider::make('Главная должна быть опубликована'),

                                        Switcher::make('Опубликовано', 'published')->default(1),

                                    ]),
                                ])->columnSpan(3),
                            ]),
                        ])->icon('document-text'),

                        Tab::make('Слайдер', [
                            Json::make('Слайды', 'slider')->fields([
                                Image::make('Изображение desktop', 'img_desktop')
                                    ->disk('public')
                                    ->dir('images/slider/slides')
                                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                                    ->removable(),
                                Image::make('Изображение mobile', 'img_mobile')
                                    ->disk('public')
                                    ->dir('images/slider/slides')
                                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                                    ->removable(),
                                Text::make('Ссылка', 'href')->unescape(),
                                Text::make('Заголовок')->unescape(),
                                Text::make('Описание')->unescape(),
                                Textarea::make('HTML')->unescape(),
                            ])->vertical()->creatable()->removable(),
                        ])->icon('photo'),

                        Tab::make('Медиа', [
                            Grid::make([

                                Column::make([


                                    Image::make(__('Изображение на всю ширину'), 'img2')
                                        ->disk('public')
                                        ->dir('content/images')
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                        ->removable(),

                                    Divider::make('НЕ пишите заголовок h1 в описании'),

                                    TinyMce::make('Описание', 'desc'),
                                ])->columnSpan(12),
                            ]),
                        ])->icon('document-text'),

                        Tab::make('SEO', [
                            Text::make('Мета-заголовок', 'metatitle')->unescape(),
                            Text::make('Мета-описание', 'description')->unescape(),
                            Text::make('Ключевые слова', 'keywords')->unescape(),
                            Textarea::make('Скрипт', 'script')->unescape(),
                        ])->icon('magnifying-glass'),

                        Tab::make('Блоки', [
                            Grid::make([
                                Column::make([
                                    Divider::make('Баннер'),
                                    Collapse::make('', [
                                        Text::make('Ссылка баннера (href)', 'home_banner_link')
                                            ->default('/poleznoe/stati/123-cap-icfm'),
                                    ]),

                                    Divider::make('Программы (плитки)'),
                                    Collapse::make('', [
                                        Text::make('Заголовок (строка 1)', 'programs_h2_title')
                                            ->default('Освоите новые навыки и ускорьте'),
                                        Text::make('Заголовок (строка 2 — выделение)', 'programs_h2_span')
                                            ->default('карьерный рост'),
                                        Json::make('Плитки', 'program_tiles')->fields([
                                            Text::make('Цвет (green/orange/blue/red/dark)', 'color'),
                                            Text::make('Ссылка (href)', 'href'),
                                            Text::make('Заголовок', 'title'),
                                            Text::make('Подпись под CTA', 'cta_text'),
                                            Text::make('Ключ буквы (m/b/c/d/r)', 'letter_key'),
                                        ])->default([
                                            ['color' => 'green',  'href' => '/obuchenie/mediator',           'title' => "Обучение\nМедиаторов",   'cta_text' => 'Обучение за 5 дней',      'letter_key' => 'm'],
                                            ['color' => 'orange', 'href' => '/obuchenie/prof-bukhgalter-rk', 'title' => "Проф.\nбухгалтер",      'cta_text' => 'Сдача до 90% студентов', 'letter_key' => 'b'],
                                            ['color' => 'blue',   'href' => '/obuchenie/kursy-cap-i-cipa',   'title' => 'CAP/CIPA',               'cta_text' => 'Лучшие лекторы Алматы', 'letter_key' => 'c'],
                                            ['color' => 'red',    'href' => '/obuchenie/dipifr',             'title' => 'ДИПИФР',                 'cta_text' => 'Теория и практика',     'letter_key' => 'd'],
                                        ])->vertical()->creatable(limit: 8)->removable(),
                                        Text::make('Ссылка «Расписание» (aside)', 'programs_aside_href')
                                            ->default('/raspisani/almaty'),
                                        Text::make('Подпись «Расписание»', 'programs_aside_cta')
                                            ->default('Подберите удобное время'),
                                    ]),

                                    Divider::make('Расписание'),
                                    Collapse::make('', [
                                        Text::make('Заголовок секции', 'schedule_heading')
                                            ->default('Занимайтесь из дома, на работе — с компьютера или смартфона.'),
                                    ]),

                                    Divider::make('Преимущества ВШЭ'),
                                    Collapse::make('', [
                                        Text::make('Заголовок (h2)', 'home_adv_h2')
                                            ->default('Преимущества Высшей Школы Экономики'),
                                        Textarea::make('Описание', 'home_adv_desc')
                                            ->default('25 лет на рынке профессионального образования. Международные стандарты обучения. Самое лучшее качество по приемлемым ценам.'),
                                        Json::make('Карточки', 'home_adv_cards')->fields([
                                            Text::make('Значение / число', 'value'),
                                            Textarea::make('Текст', 'text'),
                                        ])->default([
                                            ['value' => 'Лучшие',       'text' => 'образовательные программы. Участвуем в международных и отечественных программах по повышению квалификации работников финансовой системы'],
                                            ['value' => '27 000',       'text' => 'довольных клиентов окончившие наши курсы отзываются положительно как о качестве преподавания так и об объёме полученных знаний и информации'],
                                            ['value' => '25 лет',       'text' => 'успешного опыта и стабильная положительная репутация по праву дают нам возможность называться одним из самых сильных образовательных учреждений'],
                                            ['value' => 'Самое крупное', 'text' => 'образовательное учреждение работа во всех регионах Казахстана и ближнего зарубежья проведение корпоративных семинаров, обучение в группах'],
                                        ])->vertical()->creatable(limit: 8)->removable(),
                                        Text::make('Ссылка «Правила обучения»', 'home_adv_rules_link')->default('#'),
                                    ]),

                                    Divider::make('Форматы консалтинга (блок на главной)'),
                                    Collapse::make('', [
                                        Text::make('Заголовок', 'home_consult_title')
                                            ->default('Форматы консалтинга'),
                                        Textarea::make('Описание', 'home_consult_desc')
                                            ->default('Подберем удобный формат работы под задачу, сроки и уровень вовлечения вашей команды'),
                                        Json::make('Карточки', 'home_consult_items')->fields([
                                            Text::make('Заголовок', 'title'),
                                            Textarea::make('Описание', 'desc'),
                                            Text::make('Пункт 1', 'li_1'),
                                            Text::make('Пункт 2', 'li_2'),
                                            Text::make('Пункт 3', 'li_3'),
                                        ])->default([
                                            ['title' => 'Экспресс-диагностика', 'desc' => 'Быстрый аудит или консультационный спринт по одному участку: налоги, отчетность, договоры или клиентские процессы.', 'li_1' => 'Короткие сроки', 'li_2' => 'Фокус на одной проблеме', 'li_3' => 'Понятный план действий'],
                                            ['title' => 'Проектная работа', 'desc' => 'Полноценный проект с планом, этапами, рабочими встречами, анализом документов и итоговыми рекомендациями.', 'li_1' => 'Команда экспертов', 'li_2' => 'Согласованный календарь', 'li_3' => 'Отчет по итогам'],
                                            ['title' => 'Абонентское сопровождение', 'desc' => 'Регулярная поддержка по вопросам учета, налогов, финансов и управленческих решений на ежемесячной основе.', 'li_1' => 'Постоянный контакт', 'li_2' => 'Поддержка команды клиента', 'li_3' => 'Гибкий объем задач'],
                                        ])->vertical()->creatable(limit: 6)->removable(),
                                    ]),
                                ])->columnSpan(12),
                            ]),
                        ])->icon('squares-2x2'),

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
