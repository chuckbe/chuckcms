<?php

namespace Chuckbe\Chuckcms\Providers;

use Illuminate\Support\ServiceProvider;

class ChuckMenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ChuckMenu', function () {
            return new \Chuckbe\Chuckcms\Chuck\Accessors\Menu();
        });
    }
}
