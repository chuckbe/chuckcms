<?php

namespace Chuckbe\Chuckcms\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Chuckbe\Chuckcms\ViewComposers\MatomoComposer;

class ChuckDashboardMatomoViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'chuckcms::backend.includes.matomo', MatomoComposer::class
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}