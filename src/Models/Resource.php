<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Resource extends Eloquent
{
    protected $casts = [
        'json' => 'array',
    ];
}
