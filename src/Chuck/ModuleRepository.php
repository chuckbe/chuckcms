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

    public static function get()
    {
        return Module::get();
    }

    /**
     * Return the settings array of the module
     *
     * @var Module $module
     **/
    public function getSettings(Module $module)
    {
        return array_key_exists('settings', $module->json) ? $module->json['settings'] : [];
    }

}