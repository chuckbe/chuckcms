<?php

namespace Chuckbe\Chuckcms\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ChuckDashboardSidebarViewComposerServiceProvider extends ServiceProvider
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
            'chuckcms::backend.includes.sidebar',
            'Chuckbe\Chuckcms\ViewComposers\SidebarComposer'
        );

        View::composer(
            'chuckcms::backend.includes.navigation',
            'Chuckbe\Chuckcms\ViewComposers\SidebarComposer'
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
