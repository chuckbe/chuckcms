<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Resource extends Eloquent
{
    public function page_block()
    {
        return $this->belongsTo('Chuckbe\Chuckcms\Models\PageBlock');
    }

    protected $casts = [
        'json' => 'array',
    ];
}
