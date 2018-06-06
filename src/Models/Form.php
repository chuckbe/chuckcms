<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Form extends Eloquent
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'form'
    ];

    protected $casts = [
        'form' => 'array',
    ];
}
