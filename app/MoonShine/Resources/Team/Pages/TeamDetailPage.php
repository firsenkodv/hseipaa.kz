<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Team\Pages;

use App\MoonShine\Resources\Team\TeamResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends DetailPage<TeamResource>
 */
final class TeamDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make('ID'),
            Text::make('Заголовок', 'title'),
            Text::make('Слаг', 'slug'),
            Text::make('Подзаголовок', 'subtitle'),
            Textarea::make('Анонс', 'short_desc'),
            Image::make('Изображение', 'img')->disk('public')->dir('content/images'),
            Textarea::make('Описание', 'desc'),
            Image::make('Изображение 2', 'img2')->disk('public')->dir('content/images'),
            Textarea::make('Описание 2', 'desc2'),
            Textarea::make('HTML-блок', 'html')->unescape(),
            Textarea::make('HTML-блок 2', 'html2')->unescape(),
            Switcher::make('Опубликовано', 'published'),
            Textarea::make('Параметры', 'params'),
            File::make('Видео', 'video')->disk('public')->dir('content/video'),
            Textarea::make('Галерея', 'gallery'),
            Textarea::make('Файлы', 'files'),
            Text::make('Мета-заголовок', 'metatitle'),
            Text::make('Мета-описание', 'description'),
            Text::make('Ключевые слова', 'keywords'),
            Textarea::make('Скрипт', 'script')->unescape(),
            Number::make('Сортировка', 'sorting'),
            Textarea::make('Вопросы и ответы', 'faq'),
            Textarea::make('Дополнительное поле', 'custom_field'),
            Textarea::make('Дополнительное поле 2', 'custom_field2'),
            Textarea::make('Дополнительное поле 3', 'custom_field3'),
        ];
    }
}
