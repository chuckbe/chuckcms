<?php

namespace Chuckbe\Chuckcms\Models;

use Chuckbe\Chuckcms\Models\Scopes\SiteScope;
use Eloquent;

/**
 * @property string $slug
 * @property array  $json
 */
class Resource extends Eloquent
{
    protected $casts = [
        'json' => 'array',
    ];

    protected $fillable = ['slug', 'json'];
    
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
