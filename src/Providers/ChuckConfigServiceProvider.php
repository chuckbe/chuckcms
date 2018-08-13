<?php

namespace Chuckbe\Chuckcms\Providers;

use ChuckSite;
use Chuckbe\Chuckcms\Models\Site;

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
            'app.locale' => 'nl',
            'app.fallback_locale' => 'en',

            // UniSharp/laravel-filemanager
            'lfm_config.url_prefix' => 'dashboard/mediacenter',

            // laravel/laravel
            'auth.providers.users.model' => \Chuckbe\Chuckcms\Models\User::class
        ]);

        $site = Site::first();
        if($site !== null) {
            config([
                // mcamara/laravel-localization
                'laravellocalization.supportedLocales' => ChuckSite::getSupportedLocales(),
                'laravellocalization.useAcceptLanguageHeader' => config('lang.useAcceptLanguageHeader'),
                'laravellocalization.hideDefaultLocaleInURL' => config('lang.hideDefaultLocaleInURL'),
            ]);
        } else {
            config([
                'laravellocalization.supportedLocales' => config('lang.supportedLocales'),
                'laravellocalization.useAcceptLanguageHeader' => true,
                'laravellocalization.hideDefaultLocaleInURL' => false,
            ]);
        }
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