<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\Site;

use App\Http\Requests;

class SiteRepository
{

    public static function getSettings()
    {
    	return Site::first()->settings;
    }

}