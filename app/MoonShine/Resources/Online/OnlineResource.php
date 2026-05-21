<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Online;

use App\Models\Online;
use App\MoonShine\Resources\Online\Pages\OnlineFormPage;
use App\MoonShine\Resources\Online\Pages\OnlineIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Online, OnlineIndexPage, OnlineFormPage>
 */
#[Icon('globe-alt')]
#[Group('Контент', 'document-text')]
#[Order(16)]
class OnlineResource extends ModelResource
{
    protected string $model = Online::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Online';
    }

    protected function pages(): array
    {
        return [
            OnlineIndexPage::class,
            OnlineFormPage::class,
        ];
    }

    protected function search(): array
    {
        return ['id', 'title', 'slug'];
    }
}
