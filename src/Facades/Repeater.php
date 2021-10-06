<?php

namespace Chuckbe\Chuckcms\Facades;

use Illuminate\Support\Facades\Facade;

class Repeater extends Facade
{
    /**
     * Return facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ChuckRepeater';
    }
}
