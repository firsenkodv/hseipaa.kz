<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Seminar\Pages;

use App\MoonShine\Resources\Seminar\SeminarResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<SeminarResource>
 */
final class SeminarIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Image::make(__('Изображение'), 'img'),
            Text::make('Title', 'title')->unescape()->updateOnPreview(),
            Text::make('Title', 'title')->unescape()->updateOnPreview(),
            Switcher::make('Published', 'published')->updateOnPreview(),
            Date::make('Дата', 'created_at')->format("d.m.Y")->updateOnPreview(),
            Switcher::make('Metatitle', 'metatitle'),
            Switcher::make('Description', 'description'),
            Switcher::make('Keywords', 'keywords'),
        ];
    }
}
