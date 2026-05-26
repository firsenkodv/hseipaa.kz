<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Partner\Pages;

use App\MoonShine\Resources\Partner\PartnerResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<PartnerResource>
 */
final class PartnerIndexPage extends IndexPage
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
            Text::make('Slug', 'slug'),
            Switcher::make('Published', 'published')->updateOnPreview(),
            Text::make('Sorting', 'sorting')->updateOnPreview(),
            Switcher::make('Metatitle', 'metatitle'),
            Switcher::make('Description', 'description'),
            Switcher::make('Keywords', 'keywords'),
        ];
    }
}
