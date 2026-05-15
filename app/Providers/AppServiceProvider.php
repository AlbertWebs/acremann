<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
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
        Paginator::defaultView('pagination::tailwind');
        Paginator::defaultSimpleView('pagination::simple-tailwind');

        if ($this->app->environment('production')) {
            $rootUrl = rtrim((string) config('app.url'), '/');

            if ($rootUrl !== '') {
                URL::forceRootUrl($rootUrl);
            }

            if (str_starts_with($rootUrl, 'https://')) {
                URL::forceScheme('https');
            }
        }
    }
}
