<?php

namespace Codiiv\Laradzmanager;

use Illuminate\Support\ServiceProvider;

class LaradzmanagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([
          __DIR__.'/assets' => public_path('dzmedia/assets'),
          __DIR__.'/config/laradzmanager.php' => config_path('laradzmanager.php')
      ], 'laradzmanager');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Codiiv\Laradzmanager\LaradzmanagerController');
        $this->loadViewsFrom(__DIR__.'/views', 'laradzmanager');
    }
}
