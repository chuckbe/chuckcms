<?php

namespace Chuckbe\Chuckcms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array $content
 */
class Content extends Model
{
    protected $fillable = [
        'slug', 'type', 'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    protected $hidden = ['id', 'created_at', 'updated_at'];
}
