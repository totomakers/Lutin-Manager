<?php

namespace App\Providers;

use App\Models\User;
use App\Providers\AccountServiceProvider;
use App\User;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        \Auth::extend('custom.auth',function()
        {
            return new AccountServiceProvider(new User);
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}