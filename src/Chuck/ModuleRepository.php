<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\Module;

class ModuleRepository
{
    public static function createFromArray($array)
    {
        // updateOrCreate the module
        $find = Module::where('slug', $array['slug'])->first();

        if($find == null) {
            $result = Module::create($array);
        } else {
            $result = $find->update($array);
        }

        return $result;
    }

    public static function get($slug = null)
    {
        if(!is_null($slug)) {
            return Module::where('slug', $slug)->firstOrFail();
        }

        return Module::get();
    }

    /**
     * Return the settings array of the module -> method can be phased out
     *
     * @var Module $module
     **/
    public function getSettings(Module $module)
    {
        return $module->settings;
    }

}