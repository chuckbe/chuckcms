<?php

namespace Chuckbe\Chuckcms\Models;

use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getAllByPageId($page_id)
    {
        return $this->where('page_id', $page_id)
            ->where('lang', app()->getLocale())
            ->orderBy('order', 'asc')
            ->get();
    }
}
