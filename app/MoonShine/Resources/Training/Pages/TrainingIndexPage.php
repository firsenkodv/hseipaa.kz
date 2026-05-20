<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Training\Pages;

use App\MoonShine\Resources\Training\TrainingResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<TrainingResource>
 */
final class TrainingIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Image::make(__('Изображение'), 'img'),
            Text::make('Заголовок', 'title')->unescape()->updateOnPreview(),
            Text::make('Шаблон', 'template', fn($item) => $item->template?->label() ?? ''),
            Preview::make('Категории', 'categories', fn($item) => $item->categories->pluck('title')->implode(', ')),
            Switcher::make('Опубликовано', 'published')->updateOnPreview(),
            Text::make('Сортировка', 'sorting')->updateOnPreview(),
        ];
    }
}
