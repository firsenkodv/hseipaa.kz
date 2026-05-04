<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Pages\Pages\ContactPage;
use App\MoonShine\Pages\Pages\HomePage;
use Illuminate\Support\ServiceProvider;
use App\MoonShine\Resources\About\AboutResource;
use App\MoonShine\Resources\City\CityResource;
use App\MoonShine\Resources\Consulting\ConsultingResource;
use App\MoonShine\Resources\Document\DocumentResource;
use App\MoonShine\Resources\Online\OnlineResource;
use App\MoonShine\Resources\Training\TrainingResource;
use App\MoonShine\Resources\Useful\UsefulResource;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\Partner\PartnerResource;
use App\MoonShine\Resources\Team\TeamResource;
use App\MoonShine\Resources\Law\LawResource;
use App\MoonShine\Resources\News\NewsResource;
use App\MoonShine\Resources\Important\ImportantResource;
use App\MoonShine\Resources\Diploma\DiplomaResource;
use App\MoonShine\Resources\Seminar\SeminarResource;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                AboutResource::class,
                DocumentResource::class,
                TrainingResource::class,
                ConsultingResource::class,
                UsefulResource::class,
                OnlineResource::class,
                CityResource::class,
                TeamResource::class,
                PartnerResource::class,
                LawResource::class,
                NewsResource::class,
                ImportantResource::class,
                DiplomaResource::class,
                SeminarResource::class,
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
                HomePage::class,
                ContactPage::class,
            ])
        ;
    }
}
