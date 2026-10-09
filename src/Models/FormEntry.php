<?php

namespace Chuckbe\Chuckcms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $slug
 * @property array  $entry
 */
class FormEntry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'entry',
    ];

    protected $casts = [
        'entry' => 'array',
    ];

    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->get();
    }

    public function getById($id)
    {
        return $this->where('id', $id)->first();
    }
}
