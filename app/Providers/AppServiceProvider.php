<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
       Paginator::useBootstrap();

       View::share('site_name' , 'MY SITE');

        /**
         * Three Permission
         * 1: create_post
         * 2: edit_post
         * 3: delete_post
         */

        Gate::define('create-post', function () {
            return Auth::user()->is_admin;    //logged  in user details
        });

        Gate::define('edit-post', function () {
            return Auth::user()->is_admin;    //logged  in user details
        });

        Gate::define('delete0post', function () {
            return Auth::user()->is_admin;    //logged  in user details
        });
    }
}
