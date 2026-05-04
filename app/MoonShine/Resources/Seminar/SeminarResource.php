<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Seminar;

use App\Models\Seminar;
use App\MoonShine\Resources\Seminar\Pages\SeminarFormPage;
use App\MoonShine\Resources\Seminar\Pages\SeminarIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Seminar, SeminarIndexPage, SeminarFormPage>
 */
#[Icon('document')]
#[Group('Контент', 'document-text')]
#[Order(16)]
class SeminarResource extends ModelResource
{
    protected string $model = Seminar::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Семинары';
    }

    protected function pages(): array
    {
        return [
            SeminarIndexPage::class,
            SeminarFormPage::class,
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
