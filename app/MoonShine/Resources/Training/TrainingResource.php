<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Training;

use App\Models\Training;
use App\MoonShine\Resources\Training\Pages\TrainingFormPage;
use App\MoonShine\Resources\Training\Pages\TrainingIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Training, TrainingIndexPage, TrainingFormPage>
 */
#[Icon('academic-cap')]
#[Group('Контент', 'document-text')]
#[Order(12)]
class TrainingResource extends ModelResource
{
    protected string $model = Training::class;

    protected string $column = 'title';
    protected array $with = ['categories'];
    protected string $sortColumn = 'sorting';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Обучение';
    }

    protected function pages(): array
    {
        return [
            TrainingIndexPage::class,
            TrainingFormPage::class,
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
