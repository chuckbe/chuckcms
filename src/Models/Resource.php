<?php

namespace Chuckbe\Chuckcms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $slug
 * @property array  $json
 */
class Resource extends Model
{
    protected $casts = [
        'json' => 'array',
    ];

    protected $fillable = ['slug', 'json'];
}
