<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\Module;

class ModuleRepository
{
    public static function createFromArray($array)
    {
        // updateOrCreate the module
        $result = Module::create($array);

        return $result;
    }

    public static function get()
    {
        return Module::get();
    }

}