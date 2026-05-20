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
                                Image::make('Изображение', 'img')
                                    ->disk('public')
                                    ->dir('images/slider/slides')
                                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                                    ->removable(),
                                Text::make('Ссылка', 'href')->unescape(),
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
