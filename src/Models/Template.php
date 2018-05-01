<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Template extends Eloquent
{
    public function pages(){
    	return $this->hasMany('Chuckbe\Chuckcms\Models\Page');
    }
}
