<?php

namespace Chuckbe\Chuckcms;

use Chuckbe\Chuckcms\Commands\GenerateSuperAdmin;
use Chuckbe\Chuckcms\Commands\GenerateSite;
use Chuckbe\Chuckcms\Commands\GenerateRolesPermissions;
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
        
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        
        $this->publishes([
            __DIR__.'/resources' => public_path('chuckbe/chuckcms'),
        ], 'chuckcms-public');

        $this->publishes([
            __DIR__ . '/../config/menu.php' => config_path('menu.php'),
            __DIR__ . '/../config/lfm.php' => config_path('lfm.php'),
            __DIR__ . '/../config/lang.php' => config_path('lang.php'),
        ], 'chuckcms-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateSuperAdmin::class,
                GenerateSite::class,
                GenerateRolesPermissions::class,
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
        $this->app['App\User'] = $this->app['Chuckbe\Chuckcms\Models\User'];

        $this->app->make('Chuckbe\Chuckcms\Controllers\PageController');
        $this->app->make('Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController');
        $this->app->make('Chuckbe\Chuckcms\Controllers\Auth\LoginController');
        $this->app->make('Chuckbe\Chuckcms\Controllers\Auth\RegisterController');
        $this->app->make('Chuckbe\Chuckcms\Controllers\Auth\ResetPasswordController');
        
        $this->loadViewsFrom(__DIR__.'/views', 'chuckcms');

        $this->app->register(
            'Chuckbe\Chuckcms\Providers\ChuckSiteServiceProvider'
        );

        $this->app->register(
            'Chuckbe\Chuckcms\Providers\ChuckConfigServiceProvider'
        );

        $this->app->register(
            'Chuckbe\Chuckcms\Providers\ChuckMenuServiceProvider'
        );

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('ChuckSite', 'Chuckbe\Chuckcms\Facades\Site');
        $loader->alias('ChuckMenu', 'Chuckbe\Chuckcms\Facades\Menu');


        $this->mergeConfigFrom(
            __DIR__ . '/../config/menu.php', 'menu'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/lfm.php', 'lfm'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/lang.php', 'lang'
        );
    }
}
