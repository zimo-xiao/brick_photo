<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Dusterio\LumenPassport\LumenPassport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        LumenPassport::routes($this->app);
        
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->session()->get('access_token');
            if ($token != null) {
                try {
                    if ($user = $request->session()->get('user_info')) {
                        $out = json_decode($user);
                    } else {
                        $user = Curl::to(\env('APP_URL').'/auth')
                        ->withHeader('Authorization: Bearer '.$token)
                        ->asJson()
                        ->get();
                        $request->session()->put('user_info', json_encode($out), 5);
                    }
                    // HACK: 测试用户是否存在，故意报错
                    $user->permission;
                    return $user;
                } catch (\Exception $e) {
                    $request->session()->forget('access_token');
                    $request->session()->forget('user_info');
                    return null;
                }
            } else {
                return null;
            }
        });
    }
}