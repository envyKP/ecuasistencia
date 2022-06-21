<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
Use Schema;


class AppServiceProvider extends ServiceProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //debe ser seteado este valor, sino da problemas con los models
        Schema::defaultStringLength(191);

        //para usar el paginador de laravel
        Paginator::useBootstrap();

    }
}
