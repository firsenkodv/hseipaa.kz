<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Useful;

use App\Models\Useful;
use App\MoonShine\Resources\Useful\Pages\UsefulFormPage;
use App\MoonShine\Resources\Useful\Pages\UsefulIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Useful, UsefulIndexPage, UsefulFormPage>
 */
#[Icon('light-bulb')]
#[Group('Контент', 'document-text')]
#[Order(15)]
class UsefulResource extends ModelResource
{
    protected string $model = Useful::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Полезное';
    }

    protected function pages(): array
    {
        return [
            UsefulIndexPage::class,
            UsefulFormPage::class,
        ];
    }

    protected function search(): array
    {
        return ['id', 'title', 'slug'];
    }
}
