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

class TrainingPage extends Page
{
    public function getTitle(): string
    {
        return 'Обучение';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup('obuchenie');
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

                        Tab::make('Курс', [
                            Column::make([
                                Divider::make('Что вы получаете'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'get_title')->unescape(),
                                    Json::make('Пункты', 'get_items')->fields([
                                        Text::make('Название', 'name'),
                                    ])->vertical()->creatable(limit: 50)->removable(),
                                ]),

                                Divider::make('Требования к кандидатам'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'req_title')->unescape(),
                                    Text::make('Краткое описание', 'req_desc')->unescape(),
                                    Json::make('Карточки', 'req_items')->fields([
                                        Text::make('Заголовок', 'title'),
                                        Textarea::make('Описание', 'desc'),
                                    ])->vertical()->creatable(limit: 20)->removable(),
                                ]),

                                Divider::make('Программа курса'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'outline_title')->unescape(),
                                    Textarea::make('Описание', 'outline_desc')->unescape(),
                                    Json::make('Статистика', 'outline_stats')->fields([
                                        Text::make('Значение', 'value'),
                                        Text::make('Подпись', 'label'),
                                    ])->vertical()->creatable(limit: 3)->removable(),
                                    Json::make('Модули', 'outline_modules')->fields([
                                        Text::make('Префикс', 'label')->hint('Например: Модуль 1.'),
                                        Text::make('Заголовок', 'title'),
                                        Json::make('Пункты', 'items')->fields([
                                            Textarea::make('Текст', 'text'),
                                        ])->vertical()->creatable(limit: 20)->removable(),
                                    ])->vertical()->creatable(limit: 20)->removable(),
                                ]),
                            ]),
                        ])->icon('academic-cap'),

                        Tab::make('Блоки', [
                            Column::make([
                                Divider::make('Форматы обучения'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'edu_format_title')
                                        ->default('Форматы обучения'),
                                    Textarea::make('Описание', 'edu_format_desc')
                                        ->default('Выберите удобный формат обучения под ваши потребности и график'),
                                    Json::make('Карточки', 'edu_format_items')->fields([
                                        Text::make('Заголовок', 'title'),
                                        Textarea::make('Описание', 'desc'),
                                        Text::make('Пункт 1', 'li_1'),
                                        Text::make('Пункт 2', 'li_2'),
                                        Text::make('Пункт 3', 'li_3'),
                                    ])->default([
                                        ['title' => 'Онлайн обучение', 'desc' => 'Учитесь в удобное время из любой точки мира. Доступ к материалам 24/7, онлайн-лекции и вебинары.', 'li_1' => 'Гибкий график', 'li_2' => 'Доступ к записям', 'li_3' => 'Экономия времени'],
                                        ['title' => 'Очное обучение', 'desc' => 'Занятия в аудиториях с преподавателями. Живое общение, практические занятия и нетворкинг.', 'li_1' => 'Личное общение', 'li_2' => 'Практические занятия', 'li_3' => 'Нетворкинг'],
                                        ['title' => 'Смешанный формат', 'desc' => 'Комбинация онлайн и офлайн занятий. Теория онлайн, практика очно для максимальной эффективности.', 'li_1' => 'Лучшее из двух форматов', 'li_2' => 'Гибкость + практика', 'li_3' => 'Оптимальная цена'],
                                    ])->vertical()->creatable(limit: 6)->removable(),
                                ]),

                                Divider::make('Как проходит обучение'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'edu_steps_title')
                                        ->default('Как проходит обучение'),
                                    Textarea::make('Описание', 'edu_steps_desc')
                                        ->default('Простой и понятный процесс от регистрации до получения сертификата'),
                                    Json::make('Шаги', 'edu_steps_items')->fields([
                                        Text::make('Номер', 'num'),
                                        Text::make('Заголовок', 'title'),
                                        Textarea::make('Описание', 'desc'),
                                    ])->default([
                                        ['num' => '01', 'title' => 'Регистрация', 'desc' => 'Выберите программу и оформите заявку онлайн или по телефону'],
                                        ['num' => '02', 'title' => 'Обучение', 'desc' => 'Изучайте материалы, смотрите лекции и выполняйте практические задания'],
                                        ['num' => '03', 'title' => 'Практика', 'desc' => 'Отработка навыков на реальных кейсах под руководством экспертов'],
                                        ['num' => '04', 'title' => 'Сертификация', 'desc' => 'Сдайте итоговый экзамен и получите документ о квалификации'],
                                    ])->vertical()->creatable(limit: 8)->removable(),
                                ]),

                                Divider::make('Документы и сертификаты'),
                                Collapse::make('', [
                                    Text::make('Заголовок (h2)', 'edu_cert_title')
                                        ->default('Официальные документы и сертификаты'),
                                    Textarea::make('Описание', 'edu_cert_desc')
                                        ->default('По окончании обучения вы получите документы установленного образца, подтверждающие вашу квалификацию. Все программы лицензированы и соответствуют государственным стандартам.'),
                                    Text::make('Значок (подпись)', 'edu_cert_badge')
                                        ->default('Документы об образовании'),
                                    Json::make('Пункты списка', 'edu_cert_items')->fields([
                                        Text::make('Текст', 'text'),
                                    ])->default([
                                        ['text' => 'Документы государственного образца'],
                                        ['text' => 'Внесение в реестр квалификаций'],
                                        ['text' => 'Признание работодателями'],
                                        ['text' => 'Международное признание'],
                                    ])->vertical()->creatable(limit: 10)->removable(),
                                ]),

                                Divider::make('Отзывы клиентов'),
                                Collapse::make('', [
                                    Text::make('Заголовок', 'edu_reviews_title')
                                        ->default('Отзывы клиентов'),
                                    Textarea::make('Описание', 'edu_reviews_desc')
                                        ->default('Стать востребованным профессионалом может каждый'),
                                    Json::make('Отзывы', 'edu_reviews_items')->fields([
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
