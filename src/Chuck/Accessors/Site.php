<?php

namespace Chuckbe\Chuckcms\Chuck\Accessors;

use Chuckbe\Chuckcms\Chuck\SiteRepository;
use Chuckbe\Chuckcms\Models\Site as SiteModel;
use Exception;
use Illuminate\Support\Facades\Schema;

class Site
{
    private $siteRepository;
    private $currentSite;
    private $siteSettings;
    private $siteSupportedLocales;

    public function __construct(SiteModel $site, SiteRepository $siteRepository) 
    {
        $this->currentSite = $this->getCurrentSite($site);
        $this->siteSettings = $this->getSiteSettings($site);
        $this->siteSupportedLocales = $this->getSiteSupportedLocales($site);
        $this->siteRepository = $siteRepository;
    }

    public static function forSite($site)
    {
        return new static($site, \App::make(SiteRepository::class));
    }

    private function getSiteSettings(SiteModel $site)
    {
        $settings = $site->settings;
        return $settings;
    }

    private function getCurrentSite(SiteModel $site)
    {
        return $site;
    }

    private function getSiteSupportedLocales(SiteModel $site)
    {
        $settings = $site->settings;
        $locales = [];
        if (is_array($settings)) { 
            foreach (config('lang.allLocales') as $langKey => $langValue) {
                if (in_array($langKey, explode(',', $settings['lang']))) {
                    $locales[$langKey] = $langValue;
                }
            }
        } else {
            $allLocales = config('lang.allLocales');
            $locales['en'] = $allLocales['en'];
            $locales['nl'] = $allLocales['nl'];
        }

        return $locales;
    }

    public function getSettings()
    {
        $settings = $this->siteSettings;
        return $settings ? $settings : null;
    }

    public function getSetting($var)
    {
        $setting = $this->resolveSetting($var, $this->siteSettings);
        return $setting ? $setting : null;
    }

    public function getSite($var)
    {
        $setting = $this->resolveSiteAttribute($var, $this->currentSite);
        return $setting ? $setting : null;
    }

    public function getSupportedLocales()
    {
        $supportedLocales = $this->siteSupportedLocales;
        return $supportedLocales ? $supportedLocales : null;
    }

    public function getFeaturedLocale()
    {
        return config('lang.featuredLocale');
    }

    private function resolveSetting($var, $settings)
    {
        $split = explode('.', $var);
        foreach ($split as $value) {
            if (array_key_exists($value, $settings)) {
                $settings = $settings[$value];
            } else {
                return null;
            }
        }

        return $settings;
    }

    private function resolveSiteAttribute($var, $currentSite)
    {
        if ($var == 'domain') {
            return $currentSite->domain;
        }
        if ($var == 'name') {
            return $currentSite->name;
        }
        if ($var == 'slug') {
            return $currentSite->slug;
        }
    }

}