<?php

namespace Chuckbe\Chuckcms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $name
 */
class Menus extends Model
{
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function __construct(array $attributes = [])
    {
        //parent::construct( $attributes );
        $this->table = config('menu.table_prefix').config('menu.table_name_menus');
    }

    public static function byName($name)
    {
        return self::where('name', '=', $name)->first();
    }
}
