<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::anonymousComponentPath(resource_path('views/client/components'), 'client');
        Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin');
        Blade::anonymousComponentPath(resource_path('views/shop/components'), 'shop');
    }
}
