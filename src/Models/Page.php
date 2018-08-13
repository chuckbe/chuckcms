<?php

namespace Chuckbe\Chuckcms\Models;

use ChuckSite;

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

        $meta = [];
        foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue){
            $page->setTranslation('title', $langKey, $values->get('page_title')[$langKey]);
            $page->setTranslation('slug', $langKey, $values->get('page_slug')[$langKey]);
            
            $meta[$langKey]['title'] = $values->get('meta_title')[$langKey];
            $meta[$langKey]['description'] = $values->get('meta_description')[$langKey];
            $meta[$langKey]['keywords'] = $values->get('meta_keywords')[$langKey];
            $meta[$langKey]['og-url'] = $values->get('page_slug')[$langKey];
            $meta[$langKey]['og-type'] = 'website';
            $meta[$langKey]['og-title'] = $values->get('meta_title')[$langKey];
            $meta[$langKey]['og-description'] = $values->get('meta_description')[$langKey];
            $meta[$langKey]['og-site_name'] = $values->get('meta_title')[$langKey];
            if($values->get('meta_robots_index')[$langKey] == '1') {
                $index = 'index, ';
            } else {
                $index = 'noindex, ';
            }

            if($values->get('meta_robots_follow')[$langKey] == '1') {
                $follow = 'follow';
            } else {
                $follow = 'nofollow';
            }

            $meta[$langKey]['robots'] = $index . $follow;
            $meta[$langKey]['googlebots'] = $index . $follow;
            for ($i=0; $i < count($values->get('meta_key')[$langKey]); $i++) { 
                $meta[$langKey][$values->get('meta_key')[$langKey][$i]] = $values->get('meta_value')[$langKey][$i];
            }
        }
        $page->meta = $meta;

        $page->template_id = $values['template_id'];
        $page->active = $values['active'];
        $page->isHp = $values['isHp'];

        $page->save();
    }

    public function updatePage($values)
    {
        $page = $this->getById($values['page_id']);
        
        $meta = [];
        foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue){
            $page->setTranslation('title', $langKey, $values->get('page_title')[$langKey]);
            $page->setTranslation('slug', $langKey, $values->get('page_slug')[$langKey]);
            for ($i=0; $i < count($values->get('meta_key')[$langKey]); $i++) { 
                $meta[$langKey][$values->get('meta_key')[$langKey][$i]] = $values->get('meta_value')[$langKey][$i];
            }
        }
        $page->meta = $meta;

        $page->template_id = $values['template_id'];
        $page->active = $values['active'];
        $page->isHp = $values['isHp'];

        $page->save();
    }

    public $translatable = ['title', 'slug'];

    protected $casts = [
        'meta' => 'array',
    ];
}