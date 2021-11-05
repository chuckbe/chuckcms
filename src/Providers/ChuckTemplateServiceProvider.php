<?php

namespace Chuckbe\Chuckcms\Providers;

use Chuckbe\Chuckcms\Models\Template as TemplateModel;
use Illuminate\Support\ServiceProvider;

class ChuckTemplateServiceProvider extends ServiceProvider
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
        $this->app->bind('ChuckTemplate', function () {
            $template = TemplateModel::first();
            if ($template == null) {
                throw new Exception('Whoops! No Template Defined...');
            }

            return new \Chuckbe\Chuckcms\Chuck\Accessors\Template($template->slug);
        });
    }
}
