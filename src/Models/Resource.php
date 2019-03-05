<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

/**
 * @property string $slug
 * @property array $json
 */
class Resource extends Eloquent
{
    protected $casts = [
        'json' => 'array',
    ];

    protected $fillable = ['slug','json'];
}
