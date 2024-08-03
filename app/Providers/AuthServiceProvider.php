<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
        /**
         * Three Permission
         * 1: create_post
         * 2: edit_post
         * 3: delete_post
         */

//        Gate::define('create-post', function () {
//            return Auth::user()->is_admin;    //logged  in user details
//        });
//
//        Gate::define('edit-post', function () {
//            return Auth::user()->is_admin;    //logged  in user details
//        });
//
//        Gate::define('delete-post', function () {
//            return Auth::user()->is_admin;    //logged  in user details
//        });
    }
}
