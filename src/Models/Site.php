<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Site extends Eloquent
{
    protected $casts = [
        'settings' => 'array',
    ];
}
