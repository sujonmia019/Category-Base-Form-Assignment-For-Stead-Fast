<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFour();

        Gate::define('admin_access', function(){
            return Auth::user()->role->slug == 'admin' ? true : false;
        });

        Gate::define('user_access', function(){
            return Auth::user()->role->slug == 'user' ? true : false;
        });
    }
}
