<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\Site;

use App\Http\Requests;
use Exception;

class SiteRepository
{
    public static function getSettings()
    {
        if(Site::first()) return Site::first()->settings;
        return null;
    	
    }

    public static function getSettingByName($var)
    {
        $result = self::resolveParameter($var, Site::first()->settings);
        return $result ? $result : null;
    }

    private static function resolveParameter($var, $parameters)
    {
        $split = explode('.', $var);
        foreach ($split as $value) {
            $parameters = $parameters[$value];
        }
        return $parameters;
    }

    public static function updateOrCreateFromRequest($req)
    {
    	$settings = [];
        foreach($req->get('socialmedia') as $smKey => $smValue){$settings['socialmedia'][$smKey] = $smValue;}
        foreach($req->get('logo') as $logoKey => $logoValue){$settings['logo'][$logoKey] = $logoValue;}
        foreach($req->get('integrations') as $igsKey => $igsValue){$settings['integrations'][$igsKey] = $igsValue;}
        $settings['lang'] = implode(",",$req->get('lang'));
        
        // updateOrCreate the site
        $result = Site::updateOrCreate(
            ['id' => $req->get('site_id')],
            ['name' => $req->get('site_name'),
            'slug' => $req->get('site_slug'),
            'domain' => $req->get('site_domain'),
            'settings' => $settings]
        );

        return $result;
    }

}