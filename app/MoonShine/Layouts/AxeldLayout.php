<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;




use App\Models\Document;
use App\MoonShine\Pages\Pages\AboutPage;
use App\MoonShine\Pages\Pages\ConsultingPage;
use App\MoonShine\Pages\Pages\ContactPage;
use App\MoonShine\Pages\Pages\DiplomasPage;
use App\MoonShine\Pages\Pages\AboutCompanyPage;
use App\MoonShine\Pages\Pages\ClientsPage;
use App\MoonShine\Pages\Pages\CooperationPage;
use App\MoonShine\Pages\Pages\DocumentsPage;
use App\MoonShine\Pages\Pages\HomePage;
use App\MoonShine\Pages\Pages\ImportantPage;
use App\MoonShine\Pages\Pages\LawsPage;
use App\MoonShine\Pages\Pages\NewsPage;
use App\MoonShine\Pages\Pages\PartnersPage;
use App\MoonShine\Pages\Pages\RemotePage;
use App\MoonShine\Pages\Pages\ResourcesPage;
use App\MoonShine\Pages\Pages\SchedulePage;
use App\MoonShine\Pages\Pages\SeminarPage;
use App\MoonShine\Pages\Pages\TeamPage;
use App\MoonShine\Pages\Pages\SocialPage;
use App\MoonShine\Pages\Pages\ToastPage;
use App\MoonShine\Pages\Pages\TrainingPage;
use App\MoonShine\Resources\About\AboutResource;
use App\MoonShine\Resources\City\CityResource;
use App\MoonShine\Resources\Consulting\ConsultingResource;
use App\MoonShine\Resources\Document\DocumentResource;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\Online\OnlineResource;
use App\MoonShine\Resources\Partner\PartnerResource;
use App\MoonShine\Resources\Team\TeamResource;
use App\MoonShine\Resources\Training\TrainingResource;
use App\MoonShine\Resources\TrainingCategory\TrainingCategoryResource;
use App\MoonShine\Resources\Useful\UsefulResource;
use App\MoonShine\Resources\Law\LawResource;
use App\MoonShine\Resources\News\NewsResource;
use App\MoonShine\Resources\Important\ImportantResource;
use App\MoonShine\Resources\Diploma\DiplomaResource;
use App\MoonShine\Resources\Schedule\ScheduleResource;
use App\MoonShine\Resources\ScheduleCourse\ScheduleCourseResource;
use App\MoonShine\Resources\Seminar\SeminarResource;
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
            new Js('/js/admin/schedule-courses.js'),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('Пользователи', [
                MenuItem::make(MoonShineUserResource::class, 'Админ', 'user'),
                MenuDivider::make(),

            ]),


            MenuGroup::make(static fn() => __('Страницы'), [
                MenuItem::make(HomePage::class, 'Главная', 'home'),
                MenuItem::make(ContactPage::class, 'Контакты', 'phone'),
                MenuDivider::make(),
                MenuItem::make(AboutPage::class, 'О нас', 'document-text'),
                MenuGroup::make('Элементы', [
                    MenuItem::make(TeamPage::class, 'Команда', 'document-text'),
                    MenuItem::make(ClientsPage::class, 'Клиенты', 'document-text'),
                    MenuItem::make(PartnersPage::class, 'Партнёры', 'document-text'),
                    MenuItem::make(DocumentsPage::class, 'Документы', 'document-text'),
                    MenuItem::make(AboutCompanyPage::class, 'О компании', 'document-text'),
                    MenuItem::make(CooperationPage::class, 'Сотрудничество', 'document-text'),
                ]),
                MenuDivider::make(),
                MenuItem::make(TrainingPage::class, 'Обучение', 'document-text'),
                MenuItem::make(ConsultingPage::class, 'Консалтинг', 'document-text'),
                MenuItem::make(RemotePage::class, 'Дистанционно', 'document-text'),
                MenuDivider::make(),
                MenuItem::make(SchedulePage::class, 'Расписание', 'document-text'),
                MenuDivider::make(),
                MenuItem::make(ResourcesPage::class, 'Полезное', 'document-text'),

                MenuGroup::make('Элементы', [
                    MenuItem::make(LawsPage::class, 'Законы', 'document-text'),
                    MenuItem::make(NewsPage::class, 'Новости', 'document-text'),
                    MenuItem::make(ImportantPage::class, 'Важное', 'document-text'),
                    MenuItem::make(DiplomasPage::class, 'Дипломы', 'document-text'),
                    MenuItem::make(SeminarPage::class, 'Семинары', 'document-text'),
                ]),



            ]),


            MenuGroup::make(static fn() => __('О компании'), [
                MenuGroup::make(static fn() => __('О нас'), [
                  MenuItem::make(AboutResource::class, 'Страницы', 'folder-plus'),
                ]),
               MenuGroup::make(static fn() => __('Документы'), [
                  MenuItem::make(DocumentResource::class, 'Страницы', 'folder-plus'),
                ]),
               MenuGroup::make(static fn() => __('Партнеры'), [
                  MenuItem::make(PartnerResource::class, 'Страницы', 'folder-plus'),
                ]),
               MenuGroup::make(static fn() => __('Команда'), [
                  MenuItem::make(TeamResource::class, 'Страницы', 'folder-plus'),
                ]),

           /*     MenuItem::make(ProductCategoryResource::class, 'Категории', 'squares-2x2'),
                MenuItem::make(ProductTagResource::class, 'Теги', 'hashtag'),
                MenuItem::make(ProductResource::class, 'Сертификаты', 'squares-plus'),*/
            ]),

           MenuGroup::make(static fn() => __('Обучение'), [
               MenuItem::make(TrainingCategoryResource::class, 'Категории', 'tag'),
               MenuItem::make(TrainingResource::class, 'Страницы', 'folder-plus'),
           ]),

           MenuGroup::make(static fn() => __('Консалтинг'), [
                  MenuItem::make(ConsultingResource::class, 'Страницы', 'folder-plus'),
           ]),

            MenuGroup::make(static fn() => __('Online'), [
                MenuItem::make(OnlineResource::class, 'Страницы', 'folder-plus'),
            ]),

            MenuGroup::make(static fn() => __('Расписание'), [
                MenuItem::make(ScheduleCourseResource::class, 'Курсы', 'academic-cap'),
                MenuItem::make(ScheduleResource::class, 'Страницы', 'folder-plus'),
            ]),

           MenuGroup::make(static fn() => __('Полезное'), [
               MenuGroup::make(static fn() => __('Полезное'), [
                  MenuItem::make(UsefulResource::class, 'Страницы', 'folder-plus'),
               ]),
               MenuGroup::make(static fn() => __('Законы'), [
                  MenuItem::make(LawResource::class, 'Страницы', 'folder-plus'),
               ]),
               MenuGroup::make(static fn() => __('Новости'), [
                  MenuItem::make(NewsResource::class, 'Страницы', 'folder-plus'),
               ]),
               MenuGroup::make(static fn() => __('Важное'), [
                  MenuItem::make(ImportantResource::class, 'Страницы', 'folder-plus'),
               ]),
               MenuGroup::make(static fn() => __('Дипломы'), [
                  MenuItem::make(DiplomaResource::class, 'Страницы', 'folder-plus'),
               ]),
               MenuGroup::make(static fn() => __('Семинары'), [
                  MenuItem::make(SeminarResource::class, 'Страницы', 'folder-plus'),
               ]),

           ]),


/*            MenuGroup::make(static fn() => __('Страницы'), [
                MenuItem::make(HomePage::class, 'Главная страница', 'building-library'),
                MenuItem::make(PageResource::class, 'Страницы', 'check'),

            ]),*/


            MenuGroup::make(static fn() => __('Настройки'), [
                MenuItem::make(CityResource::class, 'Города', 'building-office-2'),
             /* MenuItem::make(SettingPage::class, 'Константы', 'adjustments-vertical'),*/
                MenuItem::make(MediaManagerPage::class, 'Media', 'film'),
                MenuItem::make(ToastPage::class, 'Toast', 'bell'),
                MenuItem::make(SocialPage::class, 'Соцсети и константы', 'globe-alt'),
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
                &copy; %d Портал
                <a href="/"
                    class="font-semibold text-primary"
                    target="_blank"
                >
                    Бухгалтеров Казахстана
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
