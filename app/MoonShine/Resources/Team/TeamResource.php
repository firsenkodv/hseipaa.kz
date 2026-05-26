<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Team;

use App\Models\Team;
use App\MoonShine\Resources\Team\Pages\TeamFormPage;
use App\MoonShine\Resources\Team\Pages\TeamIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Team, TeamIndexPage, TeamFormPage>
 */
#[Icon('users')]
#[Group('Контент', 'document-text')]
#[Order(12)]
class TeamResource extends ModelResource
{
    protected string $model = Team::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $simplePaginate = false;

    public function getTitle(): string
    {
        return 'Команда';
    }

    protected function pages(): array
    {
        return [
            TeamIndexPage::class,
            TeamFormPage::class,
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
