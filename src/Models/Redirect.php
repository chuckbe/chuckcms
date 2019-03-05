<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

/**
 * @property string $slug
 * @property string $to
 * @property int $type
 */
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
