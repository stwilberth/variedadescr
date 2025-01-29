<?php

namespace anuncielo\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if(config('app.force_https', false)) {
            URL::forceScheme('https');
        }
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\Vite::useScriptTagAttributes([
                'defer' => true
            ]);
        }
    }
}
