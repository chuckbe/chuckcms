<?php

namespace Chuckbe\Chuckcms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array $form
 */
class Form extends Model
{
    protected $fillable = [
        'title', 'slug', 'form',
    ];

    protected $casts = [
        'form' => 'array',
    ];
}
