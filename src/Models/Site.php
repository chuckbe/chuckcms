<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Site extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'domain', 'settings'
    ];

    protected $casts = [
        'settings' => 'array',
    ];
}
