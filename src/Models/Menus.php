<?php

namespace Chuckbe\Chuckcms\Models;

use Chuckbe\Chuckcms\Models\Scopes\SiteScope;
use Eloquent;

/**
 * @property int    $id
 * @property string $name
 */
class Menus extends Eloquent
{
    protected $table = 'chck_menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
 
        static::addGlobalScope(new SiteScope);
    }

    public static function byName($name)
    {
        return self::where('name', '=', $name)->first();
    }
}
