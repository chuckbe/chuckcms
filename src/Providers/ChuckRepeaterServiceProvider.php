<?php

namespace Chuckbe\Chuckcms\Providers;

use Chuckbe\Chuckcms\Chuck\RepeaterRepository;
use Chuckbe\Chuckcms\Models\Repeater;
use Illuminate\Support\ServiceProvider;

class ChuckRepeaterServiceProvider extends ServiceProvider
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
        $this->app->bind('ChuckRepeater', function () {
            return new \Chuckbe\Chuckcms\Chuck\Accessors\Repeater(\App::make(Repeater::class), \App::make(RepeaterRepository::class));
        });
    }
}
