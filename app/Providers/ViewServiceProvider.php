<?php

namespace App\Providers;

use App\View\Composers\ChangeContactComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('include.connect._change_contacts', ChangeContactComposer::class);

    }
}
