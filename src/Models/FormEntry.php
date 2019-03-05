<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class FormEntry extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'entry'
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
