<?php

namespace Chuckbe\Chuckcms\Providers;

use Illuminate\Support\ServiceProvider;

class ChuckLocaleConfigServiceProvider extends ServiceProvider
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
			'laravellocalization.supportedLocales' => [
				'nl' => array( 'name' => 'Dutch', 'script' => 'Latn', 'native' => 'Nederlands' ),
				'en'  => array( 'name' => 'English', 'script' => 'Latn', 'native' => 'English' ),
                'fr'  => array( 'name' => 'French', 'script' => 'Latn', 'native' => 'français' ),
			],

			'laravellocalization.useAcceptLanguageHeader' => true,

			'laravellocalization.hideDefaultLocaleInURL' => false
		]);
    }
}