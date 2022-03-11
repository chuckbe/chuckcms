<?php

namespace Chuckbe\Chuckcms;

use Chuckbe\Chuckcms\Commands\GenerateRolesPermissions;
use Chuckbe\Chuckcms\Commands\GenerateSite;
use Chuckbe\Chuckcms\Commands\GenerateSitemap;
use Chuckbe\Chuckcms\Commands\GenerateSuperAdmin;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

class ChuckcmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->doPublishing();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);
        $router->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateSuperAdmin::class,
                GenerateSite::class,
                GenerateSitemap::class,
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

        $this->loadViewsFrom(__DIR__.'/views', 'chuckcms');
        // publish error views + publish updated lfm views

        $this->mergeConfigFrom(__DIR__.'/../config/chuckcms.php', 'chuckcms');
        $this->mergeConfigFrom(__DIR__.'/../config/menu.php', 'menu');
        $this->mergeConfigFrom(__DIR__.'/../config/lfm.php', 'lfm');
        $this->mergeConfigFrom(__DIR__.'/../config/lang.php', 'lang');

        $this->app->register('Chuckbe\Chuckcms\Providers\ChuckSiteServiceProvider');
        $this->app->register('Chuckbe\Chuckcms\Providers\ChuckTemplateServiceProvider');
        $this->app->register('Chuckbe\Chuckcms\Providers\ChuckConfigServiceProvider');
        $this->app->register('Chuckbe\Chuckcms\Providers\ChuckServiceProvider');
        $this->app->register('Chuckbe\Chuckcms\Providers\ChuckMenuServiceProvider');
        $this->app->register('Chuckbe\Chuckcms\Providers\ChuckRepeaterServiceProvider');
        $this->app->register('Chuckbe\Chuckcms\Providers\ChuckDashboardSidebarViewComposerServiceProvider');

        $this->app->register('Msurguy\Honeypot\HoneypotServiceProvider');

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('ChuckSite', 'Chuckbe\Chuckcms\Facades\Site');
        $loader->alias('Chuck', 'Chuckbe\Chuckcms\Facades\Chuck');
        $loader->alias('ChuckRepeater', 'Chuckbe\Chuckcms\Facades\Repeater');
        $loader->alias('ChuckTemplate', 'Chuckbe\Chuckcms\Facades\Template');
        $loader->alias('ChuckMenu', 'Chuckbe\Chuckcms\Facades\Menu');
        $loader->alias('Honeypot', 'Msurguy\Honeypot\HoneypotFacade');
    }

    public function doPublishing()
    {
        if (!function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen (credit: Spatie)
            return;
        }

        $this->publishes([
            __DIR__.'/resources' => public_path('chuckbe/chuckcms'),
        ], 'chuckcms-public');

        $this->publishes([
            __DIR__.'/../config/chuckcms.php' => config_path('chuckcms.php'),
            __DIR__.'/../config/menu.php'     => config_path('menu.php'),
            __DIR__.'/../config/lfm.php'      => config_path('lfm.php'),
            __DIR__.'/../config/lang.php'     => config_path('lang.php'),
        ], 'chuckcms-config');
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @return string
     */
    public function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path.'*_'.$migrationFileName);
            })
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
