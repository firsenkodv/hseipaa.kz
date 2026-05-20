<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Schedule;

use App\Models\Schedule;
use App\MoonShine\Resources\Schedule\Pages\ScheduleFormPage;
use App\MoonShine\Resources\Schedule\Pages\ScheduleIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Schedule, ScheduleIndexPage, ScheduleFormPage>
 */
#[Icon('calendar')]
#[Group('Контент', 'document-text')]
#[Order(13)]
class ScheduleResource extends ModelResource
{
    protected string $model = Schedule::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Расписание';
    }

    protected function pages(): array
    {
        return [
            ScheduleIndexPage::class,
            ScheduleFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'title',
            'slug',
        ];
    }
}
