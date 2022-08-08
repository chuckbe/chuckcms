<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\Site;

class SiteRepository
{
    public static function updateOrCreateFromRequest($req)
    {
        $settings = [];
        foreach ($req->get('company') as $cmpKey => $cmpValue) {
            $settings['company'][$cmpKey] = $cmpValue;
        }
        foreach ($req->get('socialmedia') as $smKey => $smValue) {
            $settings['socialmedia'][$smKey] = $smValue;
        }
        foreach ($req->get('favicon') as $faviKey => $faviValue) {
            $settings['favicon'][$faviKey] = $faviValue;
        }
        foreach ($req->get('logo') as $logoKey => $logoValue) {
            $settings['logo'][$logoKey] = $logoValue;
        }
        foreach ($req->get('integrations') as $igsKey => $igsValue) {
            $settings['integrations'][$igsKey] = $igsValue;
        }
        $settings['lang'] = implode(',', $req->get('lang'));
        $settings['domain'] = $req->get('site_domain');

        // updateOrCreate the site
        $result = Site::updateOrCreate(
            ['id' => $req->get('site_id')],
            ['name'        => $req->get('site_name'),
                'slug'     => $req->get('site_slug'),
                'host'     => $req->get('site_host'),
                'domain'   => $req->get('site_domain'),
                'settings' => $settings, ]
        );

        return $result;
    }

    public static function createFromArray($array)
    {
        // updateOrCreate the site
        $result = Site::create($array);

        return $result;
    }
}
