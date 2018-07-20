<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Template extends Eloquent
{
    public function pages(){
    	return $this->hasMany('Chuckbe\Chuckcms\Models\Page');
    }

    protected $casts = [
        'fonts' => 'array',
        'css' => 'array',
        'js' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'type', 'version', 'author', 'active', 'fonts', 'css', 'js'
    ];
}
