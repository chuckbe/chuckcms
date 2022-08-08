<?php

namespace Chuckbe\Chuckcms\Models;

use Chuckbe\Chuckcms\Models\Scopes\SiteScope;
use Eloquent;

/**
 * @property string $slug
 * @property string $to
 * @property int    $type
 */
class Redirect extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'to', 'type',
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
}
