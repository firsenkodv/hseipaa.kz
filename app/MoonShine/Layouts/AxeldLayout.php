<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\Models\PersonCount;
use App\MoonShine\Pages\HomePage;

use App\MoonShine\Pages\SettingPage;
use App\MoonShine\Resources\AgeRestriction\AgeRestrictionResource;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;

use App\MoonShine\Resources\Order\OrderResource;
use App\MoonShine\Resources\OrderPaper\OrderPaperResource;
use App\MoonShine\Resources\Page\PageResource;
use App\MoonShine\Resources\PersonCount\PersonCountResource;
use App\MoonShine\Resources\ProductPriceOption\ProductPriceOptionResource;
use App\MoonShine\Resources\ProductTag\ProductTagResource;
use MoonShine\AssetManager\Js;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\MenuManager\MenuDivider;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use YuriZoom\MoonShineMediaManager\Pages\MediaManagerPage;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\Vendor\VendorResource;
use App\MoonShine\Resources\LegalEntity\LegalEntityResource;
use App\MoonShine\Resources\IndividualEntrepreneur\IndividualEntrepreneurResource;
use App\MoonShine\Resources\SelfEmployed\SelfEmployedResource;
use App\MoonShine\Resources\City\CityResource;
use App\MoonShine\Resources\Taxation\TaxationResource;
use App\MoonShine\Resources\ProductCategory\ProductCategoryResource;
use App\MoonShine\Resources\Product\ProductResource;

final class AxeldLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = PurplePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
            new Js('/js/admin/tab-persist.js'),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('Пользователи', [
                MenuItem::make(MoonShineUserResource::class, 'Админ', 'user'),
                MenuDivider::make(),

            ]),

/*            MenuGroup::make(static fn() => __('Услуги'), [
                MenuGroup::make(static fn() => __('Опции'), [
                    MenuItem::make(ProductPriceOptionResource::class, 'Опции цены сертификата', 'check'),
                    MenuItem::make(PersonCountResource::class, 'Количество человек', 'check'),
                    MenuItem::make(AgeRestrictionResource::class, 'Возрастное ограничение', 'check'),

                ]),
                MenuItem::make(ProductCategoryResource::class, 'Категории', 'squares-2x2'),
                MenuItem::make(ProductTagResource::class, 'Теги', 'hashtag'),
                MenuItem::make(ProductResource::class, 'Сертификаты', 'squares-plus'),
            ]),*/
/*            MenuGroup::make(static fn() => __('Страницы'), [
                MenuItem::make(HomePage::class, 'Главная страница', 'building-library'),
                MenuItem::make(PageResource::class, 'Страницы', 'check'),

            ]),*/


            MenuGroup::make(static fn() => __('Настройки'), [
          /*      MenuItem::make(CityResource::class, 'Города', 'building-office-2' ),
                MenuItem::make(SettingPage::class, 'Константы', 'adjustments-vertical'),*/
                MenuItem::make(MediaManagerPage::class, 'Media', 'film'),
/*                MenuItem::make(TaxationResource::class, 'Налоги', 'currency-dollar'),
                MenuGroup::make(static fn() => __('Продавцы'), [
                    MenuItem::make(LegalEntityResource::class, 'Юр.Лица'),
                    MenuItem::make(IndividualEntrepreneurResource::class, 'ИП'),
                    MenuItem::make(SelfEmployedResource::class, 'Самозанятые'),*/

                ]),




        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    protected function getFooterCopyright(): string
    {
        return \sprintf(
            <<<'HTML'
                &copy; %d Made  by
                <a href="https://t.me/AxeldMaster"
                    class="font-semibold text-primary"
                    target="_blank"
                >
                    @AxeldMaster
                </a>
                HTML,
            now()->year,
        );
    }

    protected function getFooterMenu(): array
    {
        return [
            config('app.url') => 'WebSite',
        ];
    }
}
