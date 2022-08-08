<?php

namespace Chuckbe\Chuckcms\Providers;

use Chuckbe\Chuckcms\Chuck\ModuleRepository;
use Chuckbe\Chuckcms\Chuck\SiteRepository;
use Chuckbe\Chuckcms\Models\Site;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class ChuckSiteServiceProvider extends ServiceProvider
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
        $this->app->singleton('ChuckSite', function () {
            $domain = request()->getHost();
            $path = request()->path();

            $sites = cache()->store('file')->get('chuck_sites', function () {
                return Site::all();
            });
            
            $site = $sites->filter(function ($s, $k) use ($domain) {
                return Str::endsWith($s->domain, $domain);
            })->first();

            //$site = Site::first();

            if (in_array($domain, [config('chuckcms.admin_url')])) {
                $site = cache()->store('file')->get('chuck_current_site', function () {
                    return Site::first();
                });

                //$site = Site::first();
                //load up ChuckSite for the selected site > ChuckSite::forSite(...);

                if ($path == '/') {
                    redirect()->to('dashboard')->send();
                }
            }

            if ($site == null) {
                throw new Exception('Whoops! No Site Defined...');
            }

            return new \Chuckbe\Chuckcms\Chuck\Accessors\Site($site, \App::make(SiteRepository::class), \App::make(ModuleRepository::class));
        });
    }
}
