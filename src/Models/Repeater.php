<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Repeater extends Eloquent
{
    protected $casts = [
        'json' => 'array',
    ];
}
