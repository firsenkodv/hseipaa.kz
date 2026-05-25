<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ConsultingCategory;

use App\Models\ConsultingCategory;
use App\MoonShine\Resources\ConsultingCategory\Pages\ConsultingCategoryIndexPage;
use App\MoonShine\Resources\ConsultingCategory\Pages\ConsultingCategoryFormPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<ConsultingCategory, ConsultingCategoryIndexPage, ConsultingCategoryFormPage>
 */
#[Icon('tag')]
#[Group('Контент', 'document-text')]
#[Order(15)]
class ConsultingCategoryResource extends ModelResource
{
    protected string $model = ConsultingCategory::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected SortDirection $sortDirection = SortDirection::ASC;

    public function getTitle(): string
    {
        return 'Категории консалтинга';
    }

    protected function pages(): array
    {
        return [
            ConsultingCategoryIndexPage::class,
            ConsultingCategoryFormPage::class,
        ];
    }

    protected function search(): array
    {
        return ['id', 'title'];
    }
}
