<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ScheduleCourse;

use App\Models\ScheduleCourse;
use App\MoonShine\Resources\ScheduleCourse\Pages\ScheduleCourseFormPage;
use App\MoonShine\Resources\ScheduleCourse\Pages\ScheduleCourseIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<ScheduleCourse, ScheduleCourseIndexPage, ScheduleCourseFormPage>
 */
#[Icon('academic-cap')]
class ScheduleCourseResource extends ModelResource
{
    protected string $model = ScheduleCourse::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Курсы расписания';
    }

    protected function pages(): array
    {
        return [
            ScheduleCourseIndexPage::class,
            ScheduleCourseFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'title',
        ];
    }
}
