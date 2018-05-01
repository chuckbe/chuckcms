<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;
use Spatie\Translatable\HasTranslations;

class Page extends Eloquent
{
	use HasTranslations;

    public function template(){
    	return $this->belongsTo('Chuckbe\Chuckcms\Models\Template');
    }

    public function page_blocks(){
    	return $this->hasMany('Chuckbe\Chuckcms\Models\PageBlock')->orderBy('order');
    }

    public function getById($id)
    {
    	return $this->where('id', $id)->first();
    }

    public function getByIdWithBlocks($id)
    {
    	return $this->where('id', $id)->with('page_blocks')->first();
    }

    public function create($values)
    {
        $page = new Page();
        $page->title = $values['page_title'];
        $page->slug = $values['page_slug'];
        $page->template_id = $values['template_id'];
        $page->active = $values['active'];
        $page->meta_title = $values['meta_title'];
        $page->meta_og_title = $values['meta_title'];
        $page->meta_keywords = $values['meta_keywords'];
        $page->meta_description = $values['meta_description'];
        $page->meta_og_description = $values['meta_description'];
        $page->save();
    }

    public function updatePage($values)
    {
        $page = $this->getById($values['page_id']);
        $page->title = $values['page_title'];
        $page->slug = $values['page_slug'];
        $page->template_id = $values['template_id'];
        $page->active = $values['active'];
        $page->meta_title = $values['meta_title'];
        $page->meta_og_title = $values['meta_title'];
        $page->meta_keywords = $values['meta_keywords'];
        $page->meta_description = $values['meta_description'];
        $page->meta_og_description = $values['meta_description'];
        $page->save();
    }

    public $translatable = ['title'];
}