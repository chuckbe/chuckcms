<?php

namespace Chuckbe\Chuckcms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $slug
 * @property array  $entry
 */
class FormEntry extends Model
{
    protected $fillable = [
        'slug', 'entry',
    ];

    protected $casts = [
        'entry' => 'array',
    ];
}
