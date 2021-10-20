<?php

namespace Chuckbe\Chuckcms\Facades;

use Illuminate\Support\Facades\Facade;

class Chuck extends Facade
{
    /**
     * Return facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Chuck';
    }
}
