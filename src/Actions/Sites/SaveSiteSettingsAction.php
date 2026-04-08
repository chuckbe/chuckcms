<?php

namespace Chuckbe\Chuckcms\Actions\Sites;

use Chuckbe\Chuckcms\Models\Site;
use Chuckbe\Chuckcms\Requests\Sites\SaveSiteRequest;

class SaveSiteSettingsAction
{
    /**
     * Groups inside the settings JSON that are flat key/value maps
     * coming straight from the form input of the same name.
     */
    private const FLAT_SETTING_GROUPS = [
        'company',
        'socialmedia',
        'favicon',
        'logo',
        'integrations',
    ];

    public function __invoke(SaveSiteRequest $request): Site
    {
        $settings = [];
        foreach (self::FLAT_SETTING_GROUPS as $group) {
            foreach ((array) $request->input($group, []) as $key => $value) {
                $settings[$group][$key] = $value;
            }
        }
        $settings['lang'] = implode(',', (array) $request->input('lang', []));
        $settings['domain'] = $request->input('site_domain');

        return Site::updateOrCreate(
            ['id' => $request->input('site_id')],
            [
                'name'     => $request->input('site_name'),
                'slug'     => $request->input('site_slug'),
                'domain'   => $request->input('site_domain'),
                'settings' => $settings,
            ],
        );
    }
}
