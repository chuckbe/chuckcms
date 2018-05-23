<?php

namespace Chuckbe\Chuckcms\Providers;

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
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        config([
            // mcamara/laravel-localization
			'laravellocalization.supportedLocales' => [
				'nl' => array( 'name' => 'Dutch', 'script' => 'Latn', 'native' => 'Nederlands' ),
				'en'  => array( 'name' => 'English', 'script' => 'Latn', 'native' => 'English' ),
                'fr'  => array( 'name' => 'French', 'script' => 'Latn', 'native' => 'français' ),
			],
			'laravellocalization.useAcceptLanguageHeader' => true,
			'laravellocalization.hideDefaultLocaleInURL' => false,

            // UniSharp/laravel-filemanager
            'lfm_config.url_prefix' => 'dashboard/mediacenter',

            // laravel/laravel
            'auth.providers.users.model' => \Chuckbe\Chuckcms\Models\User::class
		]);
    }
}