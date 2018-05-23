<?php

namespace Chuckbe\Chuckcms;

use Illuminate\Support\ServiceProvider;

class ChuckcmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {


        include __DIR__.'/Routes/routes.php';
        
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        
        $this->publishes([
            __DIR__.'/resources' => public_path('chuckbe/chuckcms'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/config/menu.php' => config_path('menu'),
        ]);

        $this->publishes([
            __DIR__ . '/config/lfm.php' => config_path('lfm'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['App\User'] = $this->app['Chuckbe\Chuckcms\Models\User'];

        $this->app->make('Chuckbe\Chuckcms\Controllers\PageController');
        $this->app->make('Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController');
        $this->app->make('Chuckbe\Chuckcms\Controllers\Auth\LoginController');
        $this->app->make('Chuckbe\Chuckcms\Controllers\Auth\RegisterController');
        $this->app->make('Chuckbe\Chuckcms\Controllers\Auth\ResetPasswordController');
        
        $this->loadViewsFrom(__DIR__.'/views', 'chuckcms');
        

        $this->app->register(
            'Chuckbe\Chuckcms\Providers\ChuckConfigServiceProvider'
        );

        $this->app->register(
            'Chuckbe\Chuckcms\Providers\ChuckMenuServiceProvider'
        );

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('ChuckMenu', 'Chuckbe\Chuckcms\Facades\Menu');

        $this->mergeConfigFrom(
            __DIR__ . '/config/menu.php', 'menu'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/config/lfm.php', 'lfm'
        );
    }
}
