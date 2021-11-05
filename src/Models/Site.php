<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

/**
 * @property array $settings
 */
class Site extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'domain', 'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];
}
