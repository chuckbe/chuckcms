<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Redirect extends Eloquent
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'to', 'type'
    ];
}
