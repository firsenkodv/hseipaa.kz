<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Partner;

use App\Models\Partner;
use App\MoonShine\Resources\Partner\Pages\PartnerDetailPage;
use App\MoonShine\Resources\Partner\Pages\PartnerFormPage;
use App\MoonShine\Resources\Partner\Pages\PartnerIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Partner, PartnerIndexPage, PartnerFormPage, PartnerDetailPage>
 */
#[Icon('building-office')]
#[Group('Контент', 'document-text')]
#[Order(13)]
class PartnerResource extends ModelResource
{
    protected string $model = Partner::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Партнеры';
    }

    protected function pages(): array
    {
        return [
            PartnerIndexPage::class,
            PartnerFormPage::class,
            PartnerDetailPage::class,
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
