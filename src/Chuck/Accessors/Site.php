<?php

namespace Chuckbe\Chuckcms\Chuck\Accessors;

use Chuckbe\Chuckcms\Chuck\SiteRepository;

use DB;

use App\Http\Requests;

class Site
{

    public static function getSupportedLocales()
    {
        if(DB::hasTable('sites')){
            $settings = SiteRepository::getSettings();
        } else {
            $settings = 'nl';
        }
    	$arr = [];
    	foreach(config('lang.allLocales') as $langKey => $langValue){
    		if( in_array($langKey, explode(',',$settings['lang']) ) ){
    			$arr[$langKey] = $langValue;
    		}
    	}
    	return $arr;
    }

    public static function getSetting($var)
    {
        return SiteRepository::getSettingByName($var);
    }

}