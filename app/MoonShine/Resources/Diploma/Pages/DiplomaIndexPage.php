<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Diploma\Pages;

use App\MoonShine\Resources\Diploma\DiplomaResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<DiplomaResource>
 */
final class DiplomaIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Text::make('Заголовок', 'title'),
            Text::make('ФИО', 'fio')->updateOnPreview(),
            Date::make('Дата выдачи', 'issued_at')->format('d.m.Y'),
            Text::make('Дисциплина', 'discipline')->updateOnPreview(),
            Switcher::make('Опубликовано', 'published')->updateOnPreview(),
           // Text::make('Сортировка', 'sorting')->updateOnPreview(),
        ];
    }
}
