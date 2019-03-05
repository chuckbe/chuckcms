<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

/**
 * @property int $id
 * @property string $name
 */
class Menus extends Eloquent
{
    protected $table = 'menus';

    public function __construct( array $attributes = [] ){
        //parent::construct( $attributes );
        $this->table = config('menu.table_prefix') . config('menu.table_name_menus');
    }

    public static function byName($name)
    {
        return self::where('name', '=', $name)->first();
    }

}
