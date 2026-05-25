<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Consulting;

use App\Models\Consulting;
use App\MoonShine\Resources\Consulting\Pages\ConsultingFormPage;
use App\MoonShine\Resources\Consulting\Pages\ConsultingIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Consulting, ConsultingIndexPage, ConsultingFormPage>
 */
#[Icon('briefcase')]
#[Group('Контент', 'document-text')]
#[Order(14)]
class ConsultingResource extends ModelResource
{
    protected string $model = Consulting::class;

    protected string $column = 'title';
    protected array $with = ['categories'];
    protected string $sortColumn = 'sorting';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Консалтинг';
    }

    protected function pages(): array
    {
        return [
            ConsultingIndexPage::class,
            ConsultingFormPage::class,
        ];
    }

    protected function search(): array
    {
        return ['id', 'title', 'slug'];
    }
}
