<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Seo\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\Alert;
use Throwable;

final class SeoIndexPage extends IndexPage
{
    protected ?string $alias = 'index-page';

    /**
     * @return list<\MoonShine\Contracts\UI\ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            Alert::make(type: 'info')->content('Тут выведены страницы, где не заполнены мета-теги. Редактирование мета-тегов на страницах ресурсов.'),
            ...parent::topLayer(),
        ];
    }
}
