<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\About;

use App\Models\About;
use App\MoonShine\Resources\About\Pages\AboutDetailPage;
use App\MoonShine\Resources\About\Pages\AboutFormPage;
use App\MoonShine\Resources\About\Pages\AboutIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<About, AboutIndexPage, AboutFormPage, AboutDetailPage>
 */
#[Icon('information-circle')]
#[Group('Контент', 'document-text')]
#[Order(10)]
class AboutResource extends ModelResource
{
    protected string $model = About::class;

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';
    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'О нас';
    }

    protected function pages(): array
    {
        return [
            AboutIndexPage::class,
            AboutFormPage::class,
            AboutDetailPage::class,
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
