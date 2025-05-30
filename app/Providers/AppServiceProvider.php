<?php

namespace anuncielo\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
            \Illuminate\Support\Facades\Vite::useScriptTagAttributes([
                'defer' => true
            ]);
        }
    }
}
