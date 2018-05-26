<?php

namespace Chuckbe\Chuckcms\Providers;

use Illuminate\Support\ServiceProvider;

class ChuckSiteServiceProvider extends ServiceProvider
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
        $this->app->bind('ChuckSite',function(){
            return new \Chuckbe\Chuckcms\Chuck\Accessors\Site;
        });
    }
}