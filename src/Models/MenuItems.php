<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

/**
 * @property int $id
 * @property string $label
 * @property string $link
 * @property string $class
 * @property int $menu
 * @property int $sort
 * @property int $parent
 * @property int $depth
 */
class MenuItems extends Eloquent
{

    protected $table = null;

    public function __construct( array $attributes = [] ){
        //parent::construct( $attributes );
        $this->table = config('menu.table_prefix') . config('menu.table_name_items');
    }

    public function getsons($id) {
        return $this -> where("parent", $id) -> get();
    }
    public function getall($id) {
        return $this -> where("menu", $id) -> orderBy("sort", "asc")->get();
    }

    public static function getNextSortRoot($menu){
        return self::where('menu',$menu)->max('sort') + 1;
    }

}
