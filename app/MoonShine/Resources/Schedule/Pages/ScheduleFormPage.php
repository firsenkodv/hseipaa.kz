<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Schedule\Pages;

use App\Enums\Months\Month;
use App\Enums\Resources\FullTemplate;
use App\Enums\Schedule\ScheduleDateType;
use App\Models\Schedule;
use App\Models\ScheduleCourse;
use App\MoonShine\Resources\Schedule\ScheduleResource;
use App\MoonShine\Resources\ScheduleCourse\ScheduleCourseResource;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use App\Support\FileNaming;
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
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Illuminate\Http\UploadedFile;
use Throwable;

/**
 * @extends FormPage<ScheduleResource, Schedule>
 */
final class ScheduleFormPage extends FormPage
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
                                    Text::make('Для меню', 'menu_title')->unescape(),
                                    Slug::make('Slug', 'slug')->from('title')->unique()->locked(),
                                ]),
                                Textarea::make('Краткое описание', 'short_desc')->unescape(),
                            ])->columnSpan(9),

                            Column::make([
                                Box::make([
                                    Switcher::make('Опубликовано', 'published')->default(1),
                                    Number::make('Сортировка', 'sorting')->default(1),
                                    Select::make('Шаблон', 'template')
                                        ->options(FullTemplate::toOptions())
                                        ->default(FullTemplate::Default->value)
                                        ->required(),
                                ]),
                            ])->columnSpan(3),
                        ]),
                    ])->icon('document-text'),
                    Tab::make('Курсы', [
                        Grid::make([
                            Column::make([
                                Divider::make('Расписание курсов'),
                                Json::make('', 'courses')->fields([
                                    Select::make('Курс', 'course_id')
                                        ->options(fn() => ScheduleCourse::orderBy('sorting')->pluck('title', 'id')->toArray())
                                        ->searchable(),
                                    Select::make('Месяцы', 'months')
                                        ->options(Month::toOptions())
                                        ->multiple(),
                                    Select::make('Дата', 'date_type')
                                        ->options(ScheduleDateType::toOptions())
                                        ->nullable(),
                                    Date::make('Дата начала', 'date'),
                                    Text::make('Примечание', 'note')->default('вечерняя группа'),
                                    Text::make('Время проведения', 'time'),
                                    Number::make('Стоимость', 'price'),
                                    Select::make('Валюта', 'currency')
                                        ->options(function () {
                                            $default  = \App\Models\Setting::getGroup('social')->data['currency'] ?? 'KZT';
                                            $all      = config('currency.currency');
                                            $sorted   = [$default => $all[$default]] + $all;
                                            return collect($sorted)
                                                ->map(fn($symbol, $code) => "{$code} ({$symbol})")
                                                ->toArray();
                                        })
                                        ->default(fn() => \App\Models\Setting::getGroup('social')->data['currency'] ?? 'KZT'),
                                    Number::make('Академических часов', 'hours'),
                                ])->creatable()->removable(),
                            ])->columnSpan(12),
                        ]),
                    ])->icon('academic-cap'),

                    Tab::make('Медиа', [
                        Grid::make([
                            Column::make([

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
        return [
            'courses' => [
                'nullable',
                'array',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (!is_array($value)) {
                        return;
                    }
                    foreach ($value as $index => $row) {
                        $hasMonths = !empty($row['months']) && count((array) $row['months']) > 0;
                        $hasDate   = isset($row['date']) && $row['date'] !== '' && $row['date'] !== null;
                        if (!$hasMonths && !$hasDate) {
                            $fail('Строка ' . ($index + 1) . ': необходимо заполнить «Месяцы» или «Дата начала».');
                        }
                    }
                },
            ],
        ];
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
