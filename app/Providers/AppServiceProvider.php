<?php

namespace App\Providers;

use App\Services\Apps;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Apps::class, function ($app) {
            return new Apps(\env('APP_CONFIG'));
        });
    }
}
