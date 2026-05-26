<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Important;

use App\Models\Important;
use App\MoonShine\Resources\Important\Pages\ImportantFormPage;
use App\MoonShine\Resources\Important\Pages\ImportantIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Important, ImportantIndexPage, ImportantFormPage>
 */
#[Icon('document')]
#[Group('Контент', 'document-text')]
#[Order(14)]
class ImportantResource extends ModelResource
{
    protected string $model = Important::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected bool $simplePaginate = false;

    public function getTitle(): string
    {
        return 'Важное';
    }

    protected function pages(): array
    {
        return [
            ImportantIndexPage::class,
            ImportantFormPage::class,
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
