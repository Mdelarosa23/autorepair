<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::share('siteContact', SiteSetting::contactSettings());
        View::share('siteAboutUs', SiteSetting::aboutUsSettings());
        View::share('siteBusiness', SiteSetting::businessProfile());
        View::share('siteSeoDefaults', SiteSetting::seoDefaults());
    }
}
