<?php

namespace Chuckbe\Chuckcms\Tests;

use Chuckbe\Chuckcms\ChuckcmsServiceProvider;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [
            ChuckcmsServiceProvider::class,
            \Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class,
            \Spatie\Permission\PermissionServiceProvider::class,
            \Spatie\EloquentSortable\EloquentSortableServiceProvider::class,
            \Spatie\Translatable\TranslatableServiceProvider::class,
            \UniSharp\LaravelFilemanager\LaravelFilemanagerServiceProvider::class,
            \Laravel\Ui\UiServiceProvider::class,
            \Spatie\Sitemap\SitemapServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'LaravelLocalization' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function defineRoutes($router): void
    {
        // Same order as the README: the frontend route is a catch-all.
        Route::group([], function () {
            \Chuck::auth();
            \Chuck::routes();
            \Chuck::frontend();
        });
    }

    /**
     * Seed what a fresh install has after following the README:
     * roles/permissions, a site, an active template and a super admin.
     */
    protected function seedCms(): User
    {
        $this->artisan('chuckcms:generate-roles-permissions')->assertSuccessful();

        $this->artisan('chuckcms:generate-site')
            ->expectsQuestion('What is name of the site? ', 'Smoke Test Site')
            ->expectsQuestion('What is the unique slug of the site? ', 'smoke')
            ->expectsQuestion('What will be the domain of this site? E.G. http://google.be ', 'http://smoke.test')
            ->assertSuccessful();

        // ChuckConfigServiceProvider configures localization at boot, and only
        // reads the site's settings when a site already exists. In tests the
        // database is empty at boot, so apply what an installed site gets.
        config([
            'laravellocalization.supportedLocales'        => \ChuckSite::getSupportedLocales(),
            'laravellocalization.useAcceptLanguageHeader' => config('lang.useAcceptLanguageHeader'),
            'laravellocalization.hideDefaultLocaleInURL'  => config('lang.hideDefaultLocaleInURL'),
        ]);

        View::addNamespace('chuck-fixture', __DIR__.'/fixtures/views');

        Template::create([
            'name'     => 'Fixture Template',
            'slug'     => 'fixture',
            'hintpath' => 'chuck-fixture',
            'path'     => $this->templatePath(),
            'type'     => 'default',
            'version'  => '1.0',
            'author'   => 'Smoke tests',
            'active'   => 1,
            'fonts'    => ['raw' => ''],
            'css'      => [],
            'js'       => [],
            'json'     => [],
        ]);

        $admin = User::create([
            'name'     => 'Smoke Admin',
            'email'    => 'admin@smoke.test',
            'password' => bcrypt('Secret123!'),
            'token'    => 'admin-token',
            'active'   => 1,
        ]);
        $admin->assignRole('super-admin');

        return $admin;
    }

    protected function templatePath(): string
    {
        return __DIR__.'/fixtures/template';
    }
}
