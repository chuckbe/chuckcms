<?php

namespace Chuckbe\Chuckcms\Providers;

use ChuckSite;

use Illuminate\Support\ServiceProvider;

class ChuckConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        config([
            // mcamara/laravel-localization
            'laravellocalization.supportedLocales' => ChuckSite::getSupportedLocales(),
            'laravellocalization.useAcceptLanguageHeader' => true,
            'laravellocalization.hideDefaultLocaleInURL' => false,

            // UniSharp/laravel-filemanager
            'lfm_config.url_prefix' => 'dashboard/mediacenter',

            // laravel/laravel
            'auth.providers.users.model' => \Chuckbe\Chuckcms\Models\User::class
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}