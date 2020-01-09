<?php 
namespace Chuckbe\Chuckcms\Facades;
use Illuminate\Support\Facades\Facade;

class Template extends Facade {
    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ChuckTemplate';
    }
}