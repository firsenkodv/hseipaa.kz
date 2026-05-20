<?php

namespace App\Providers;

use App\Models\Setting;
use App\View\Components\Modules\Advantages;
use App\View\Components\Modules\AboutJoin;
use App\View\Components\Socials\Socials;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(5)
                /*      ->letters()
                      ->numbers()
                      ->symbols()
                      ->mixedCase()
                      ->uncompromised()*/;
        });

        Blade::component('modules.advantages', Advantages::class);
        Blade::component('modules.about-join', AboutJoin::class);
        Blade::component('socials.socials', Socials::class);

        View::composer('templates.axeld.footer', function ($view) {
            $view->with('social', Setting::getGroup('social')->data ?? []);
        });
    }
}
