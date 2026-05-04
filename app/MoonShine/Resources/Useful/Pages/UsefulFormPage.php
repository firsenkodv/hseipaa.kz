<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Useful\Pages;

use App\Models\Useful;
use App\MoonShine\Resources\Useful\UsefulResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;

/**
 * @extends FormPage<UsefulResource, Useful>
 */
final class UsefulFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make('Основное', [
                        ID::make('ID'),
                        Grid::make([
                            Column::make([
                                Box::make([
                                    Text::make('Заголовок', 'title')->required()->unescape(),
                                    Slug::make('Slug', 'slug')->from('title')->unique()->locked(),
                                ]),
                                Text::make('Подзаголовок', 'subtitle')->unescape(),
                                TinyMce::make('Краткое описание', 'short_desc'),
                            ])->columnSpan(9),

                            Column::make([
                                Box::make([
                                    Switcher::make('Опубликовано', 'published')->default(1),
                                    Number::make('Сортировка', 'sorting')->default(1),
                                ]),
                            ])->columnSpan(3),
                        ]),
                    ])->icon('document-text'),

                    Tab::make('Медиа', [
                        Grid::make([
                            Column::make([
                                Image::make(__('Изображение'), 'img')
                                    ->disk('public')
                                    ->dir('content/images')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                    ->removable(),

                                File::make('Видео', 'video')
                                    ->disk('public')
                                    ->dir('content/video')
                                    ->accept('video/*'),

                                Collapse::make('Галерея', [
                                    Json::make('', 'gallery')->fields([
                                        Text::make('', 'label')->hint('Заголовок изображения'),
                                        Image::make(__('Изображение'), 'image')
                                            ->disk('public')
                                            ->dir('content/gallery')
                                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                            ->removable(),
                                    ])->vertical()->creatable(limit: 100)->removable(),
                                ]),

                                Collapse::make('Файлы', [
                                    Json::make('', 'files')->fields([
                                        Text::make('', 'label')->hint('Заголовок'),
                                        File::make('', 'file')
                                            ->disk('public')
                                            ->dir('content/files')->hint('Файл'),
                                    ])->vertical()->creatable(limit: 100)->removable(),
                                ]),
                            ])->columnSpan(9),

                            Column::make([])->columnSpan(3),

                            Column::make([
                                Textarea::make('HTML-блок', 'html'),
                                TinyMce::make('Описание', 'desc'),

                                Image::make(__('Изображение на всю ширину'), 'img2')
                                    ->disk('public')
                                    ->dir('content/images')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                    ->removable(),

                                Textarea::make('HTML-блок 2', 'html2'),
                                TinyMce::make('Описание 2', 'desc2'),
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
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [];
    }

    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [...parent::topLayer()];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [...parent::mainLayer()];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [...parent::bottomLayer()];
    }
}
