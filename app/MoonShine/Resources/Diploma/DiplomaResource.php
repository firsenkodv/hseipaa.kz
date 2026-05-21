<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Diploma;

use App\Models\Diploma;
use App\MoonShine\Resources\Diploma\Pages\DiplomaFormPage;
use App\MoonShine\Resources\Diploma\Pages\DiplomaIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Diploma, DiplomaIndexPage, DiplomaFormPage>
 */
#[Icon('document')]
#[Group('Контент', 'document-text')]
#[Order(15)]
class DiplomaResource extends ModelResource
{
    protected string $model = Diploma::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected bool $simplePaginate = false;

    public function getTitle(): string
    {
        return 'Дипломы';
    }

    protected function pages(): array
    {
        return [
            DiplomaIndexPage::class,
            DiplomaFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'title',
            'fio',
            'discipline',
        ];
    }
}
