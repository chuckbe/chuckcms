<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Repeater extends Eloquent
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'url', 'page', 'json'
    ];

    protected $casts = [
        'json' => 'array',
    ];
}
