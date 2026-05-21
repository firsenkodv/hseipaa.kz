<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Diploma\Pages;

use App\Models\Diploma;
use App\MoonShine\Resources\Diploma\DiplomaResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends FormPage<DiplomaResource, Diploma>
 */
final class DiplomaFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Grid::make([
                    Column::make([
                        Text::make('Заголовок', 'title')->required()->unescape(),
                        Text::make('ФИО', 'fio')->unescape(),
                        Date::make('Дата выдачи', 'issued_at'),
                        Text::make('Дисциплина', 'discipline')->unescape(),
                    ])->columnSpan(9),

                    Column::make([
                        Box::make([
                            Switcher::make('Опубликовано', 'published')->default(1),
                            Number::make('Сортировка', 'sorting')->default(1),
                        ]),
                    ])->columnSpan(3),
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
