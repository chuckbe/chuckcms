<?php

namespace Chuckbe\Chuckcms\Providers;

use Chuckbe\Chuckcms\Chuck\SiteRepository;
use Chuckbe\Chuckcms\Models\Site;
use Exception;
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
        $site = Site::first();
        if($site == null) {
            throw new Exception('Whoops! No Site Defined...');
        } else {
            $this->app->singleton('ChuckSite',function(){   
                return new \Chuckbe\Chuckcms\Chuck\Accessors\Site($site, \App::make(SiteRepository::class));
            });
        }
    }
}