<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ConsultingCategory\Pages;

use App\MoonShine\Resources\ConsultingCategory\ConsultingCategoryResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<ConsultingCategoryResource>
 */
final class ConsultingCategoryIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'title')->unescape()->updateOnPreview(),
            Text::make('Сортировка', 'sorting')->updateOnPreview(),
        ];
    }
}
