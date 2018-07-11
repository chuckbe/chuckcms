<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Content extends Eloquent
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'type', 'content'
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->get();
    }
}
