<?php

namespace Chuckbe\Chuckcms\Providers;

use Chuckbe\Chuckcms\Models\Site;
use ChuckSite;
use Illuminate\Support\ServiceProvider;
use Schema;

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
            'app.locale'          => 'nl',
            'app.fallback_locale' => 'en',

            // UniSharp/laravel-filemanager
            'lfm_config.url_prefix' => 'dashboard/mediacenter',

            // laravel/laravel
            'auth.providers.users.model' => \Chuckbe\Chuckcms\Models\User::class,
        ]);

        if (Schema::hasTable('sites')) {
            $site = Site::first();
        } else {
            $site = null;
        }

        if ($site !== null) {
            config([
                // mcamara/laravel-localization
                'laravellocalization.supportedLocales'        => ChuckSite::getSupportedLocales(),
                'laravellocalization.useAcceptLanguageHeader' => config('lang.useAcceptLanguageHeader'),
                'laravellocalization.hideDefaultLocaleInURL'  => config('lang.hideDefaultLocaleInURL'),
            ]);
        } else {
            config([
                'laravellocalization.supportedLocales'        => config('lang.supportedLocales'),
                'laravellocalization.useAcceptLanguageHeader' => true,
                'laravellocalization.hideDefaultLocaleInURL'  => false,
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
