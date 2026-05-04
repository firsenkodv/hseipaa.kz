<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Law;

use App\Models\Law;
use App\MoonShine\Resources\Law\Pages\LawFormPage;
use App\MoonShine\Resources\Law\Pages\LawIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Law, LawIndexPage, LawFormPage>
 */
#[Icon('document')]
#[Group('Контент', 'document-text')]
#[Order(12)]
class LawResource extends ModelResource
{
    protected string $model = Law::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Законы';
    }

    protected function pages(): array
    {
        return [
            LawIndexPage::class,
            LawFormPage::class,
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
