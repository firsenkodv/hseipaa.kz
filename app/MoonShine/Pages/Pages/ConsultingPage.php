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

class ConsultingPage extends Page
{
    public function getTitle(): string
    {
        return 'Консалтинг';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup('konsalting');
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
                            Collapse::make('Статистика в шапке', [
                                Json::make('', 'hero_stats')
                                    ->fields([
                                        Text::make('Значение', 'value'),
                                        Text::make('Подпись', 'label'),
                                    ])
                                    ->default([
                                        ['value' => '50+',    'label' => 'Программ'],
                                        ['value' => '5 000+', 'label' => 'Выпускников'],
                                        ['value' => '12',     'label' => 'Направлений'],
                                    ])
                                    ->vertical()
                                    ->creatable()
                                    ->removable(),
                            ]),
                        ])->icon('document-text'),

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

                        Tab::make('Блоки', [
                            Column::make([
                                Divider::make('Форматы консалтинга'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'konsalt_format_title')
                                        ->default('Форматы консалтинга'),
                                    Textarea::make('Описание', 'konsalt_format_desc')
                                        ->default('Подберем удобный формат работы под задачу, сроки и уровень вовлечения вашей команды'),
                                    Json::make('Карточки', 'konsalt_format_items')->fields([
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

                                Divider::make('Как проходит проект'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'konsalt_steps_title')
                                        ->default('Как проходит проект'),
                                    Textarea::make('Описание', 'konsalt_steps_desc')
                                        ->default('Понятный процесс от постановки задачи до итогового отчета и сопровождения внедрения'),
                                    Json::make('Шаги', 'konsalt_steps_items')->fields([
                                        Text::make('Номер', 'num'),
                                        Text::make('Заголовок', 'title'),
                                        Textarea::make('Описание', 'desc'),
                                    ])->default([
                                        ['num' => '01', 'title' => 'Бриф', 'desc' => 'Фиксируем задачу, цели, сроки, формат взаимодействия и состав рабочей группы'],
                                        ['num' => '02', 'title' => 'Диагностика', 'desc' => 'Собираем документы, проводим интервью, анализируем процессы, отчетность и риски'],
                                        ['num' => '03', 'title' => 'Решение', 'desc' => 'Формируем выводы, согласовываем приоритеты и готовим рекомендации под вашу команду'],
                                        ['num' => '04', 'title' => 'Сопровождение', 'desc' => 'Передаем отчет, обсуждаем внедрение и при необходимости остаемся на абонентской поддержке'],
                                    ])->vertical()->creatable(limit: 8)->removable(),
                                ]),

                                Divider::make('Документы и результаты проекта'),
                                Collapse::make('', [
                                    Text::make('Заголовок (h2)', 'konsalt_docs_title')
                                        ->default('Официальные документы и результаты проекта'),
                                    Textarea::make('Описание', 'konsalt_docs_desc')
                                        ->default('По итогам проекта вы получаете отчет, перечень рисков, рекомендации и материалы для внутренней команды. Формат результата зависит от услуги и целей проекта.'),
                                    Text::make('Значок (подпись)', 'konsalt_docs_badge')
                                        ->default('Документы и результаты проекта'),
                                    Json::make('Пункты списка', 'konsalt_docs_items')->fields([
                                        Text::make('Текст', 'text'),
                                    ])->default([
                                        ['text' => 'Итоговый отчет и карта рисков'],
                                        ['text' => 'План корректирующих действий'],
                                        ['text' => 'Рекомендации для руководства'],
                                        ['text' => 'Материалы для внутренней команды'],
                                    ])->vertical()->creatable(limit: 10)->removable(),
                                ]),

                                Divider::make('Отзывы клиентов'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'konsalt_reviews_title')
                                        ->default('Отзывы клиентов'),
                                    Textarea::make('Описание', 'konsalt_reviews_desc')
                                        ->default('Стать востребованным профессионалом может каждый'),
                                    Json::make('Отзывы', 'konsalt_reviews_items')->fields([
                                        Text::make('Имя', 'name'),
                                        Text::make('Должность', 'role'),
                                        Text::make('Обложка (путь в storage)', 'cover')->hint('Например: images/img/review-card-1.jpg'),
                                        Text::make('Аватар (путь в storage)', 'avatar')->hint('Например: images/img/review-author-1.png'),
                                        Text::make('Ссылка YouTube embed', 'video_url')->hint('Например: https://www.youtube.com/embed/XXXX?autoplay=1&rel=0'),
                                    ])->default([
                                        ['name' => 'Данияр Сейітов', 'role' => 'Руководитель проекта', 'cover' => 'images/img/review-card-1.jpg', 'avatar' => 'images/img/review-author-1.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
                                        ['name' => 'Арман Ашимов', 'role' => 'Инженер-программист', 'cover' => 'images/img/review-card-2.jpg', 'avatar' => 'images/img/review-author-2.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
                                        ['name' => 'Аружан Нұрсұлтан', 'role' => 'Дизайнер пользовательского опыта', 'cover' => 'images/img/review-card-3.jpg', 'avatar' => 'images/img/review-author-3.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
                                        ['name' => 'Ерлан Тұрар', 'role' => 'Аналитик данных', 'cover' => 'images/img/review-card-4.jpg', 'avatar' => 'images/img/review-author-4.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
                                        ['name' => 'Айгерим Садыкова', 'role' => 'Кредитный аналитик', 'cover' => 'images/img/review-card-2.jpg', 'avatar' => 'images/img/review-author-1.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
                                    ])->vertical()->creatable(limit: 10)->removable(),
                                ]),
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
