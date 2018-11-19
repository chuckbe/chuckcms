<?php

namespace Chuckbe\Chuckcms\Models;

use ChuckSite;

use Eloquent;

class Module extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'hintpath', 'path', 'type', 'version', 'author', 'json'
    ];

    /**
     * The attributes that are castable.
     *
     * @var array
     */
    protected $casts = [
        'json' => 'array',
    ];
}