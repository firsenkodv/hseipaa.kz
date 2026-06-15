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
