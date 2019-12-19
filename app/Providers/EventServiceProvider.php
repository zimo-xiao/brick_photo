<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Facade;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        \Event::listen('laravels.received_request', function (\Illuminate\Http\Request $req, $app) {
            Facade::clearResolvedInstance('auth');
        });
    }
}
