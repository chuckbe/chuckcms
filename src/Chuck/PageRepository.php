<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\Page;
use ChuckSite;
use Illuminate\Http\Request;

class PageRepository
{
    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function find(string $id)
    {
        return $this->page->where('id', $id)->first();
    }

    public function create(Request $request)
    {
        $page = new Page();

        $meta = [];
        foreach (ChuckSite::getSupportedLocales() as $langKey => $langValue) {
            $page->setTranslation('title', $langKey, $request->get('page_title')[$langKey]);
            $page->setTranslation('slug', $langKey, $request->get('page_slug')[$langKey]);

            $meta[$langKey]['title'] = $request->get('meta_title')[$langKey];
            $meta[$langKey]['description'] = $request->get('meta_description')[$langKey];
            $meta[$langKey]['keywords'] = $request->get('meta_keywords')[$langKey];

            $meta[$langKey]['og:url'] = $request->get('page_slug')[$langKey];
            $meta[$langKey]['og:type'] = 'website';
            $meta[$langKey]['og:title'] = $request->get('meta_title')[$langKey];
            $meta[$langKey]['og:description'] = $request->get('meta_description')[$langKey];
            $meta[$langKey]['og:site_name'] = $request->get('meta_title')[$langKey];
            $meta[$langKey]['og:image'] = $request->get('meta_image');

            if ($request->get('meta_robots_index')[$langKey] == '1') {
                $index = 'index, ';
            } else {
                $index = 'noindex, ';
            }

            if ($request->get('meta_robots_follow')[$langKey] == '1') {
                $follow = 'follow';
            } else {
                $follow = 'nofollow';
            }

            $meta[$langKey]['robots'] = $index.$follow;
            $meta[$langKey]['googlebots'] = $index.$follow;

            $count = count($request->get('meta_key')[$langKey]);
            for ($i = 0; $i < $count; $i++) {
                $meta[$langKey][$request->get('meta_key')[$langKey][$i]] = $request->get('meta_value')[$langKey][$i];
            }
        }
        $page->meta = $meta;

        $page->template_id = $request['template_id'];
        $page->page = $request['page'];
        $page->active = $request['active'];
        $page->isHp = $request['isHp'];
        $page->order = ($this->page->max('order') ?? 0) + 1;

        $page->css = $request->get('css');
        $page->js = $request->get('js');

        $page->save();
    }

    public function updatePage($request)
    {
        $page = $this->find($request['page_id']);

        $meta = [];
        foreach (ChuckSite::getSupportedLocales() as $langKey => $langValue) {
            $page->setTranslation('title', $langKey, $request->get('page_title')[$langKey]);
            $page->setTranslation('slug', $langKey, $request->get('page_slug')[$langKey]);

            $meta[$langKey]['title'] = $request->get('meta_title')[$langKey];
            $meta[$langKey]['description'] = $request->get('meta_description')[$langKey];
            $meta[$langKey]['keywords'] = $request->get('meta_keywords')[$langKey];

            $meta[$langKey]['og:url'] = $request->get('page_slug')[$langKey];
            $meta[$langKey]['og:type'] = 'website';
            $meta[$langKey]['og:title'] = $request->get('meta_title')[$langKey];
            $meta[$langKey]['og:description'] = $request->get('meta_description')[$langKey];
            $meta[$langKey]['og:site_name'] = $request->get('meta_title')[$langKey];
            $meta[$langKey]['og:image'] = $request->get('meta_image');

            if ($request->get('meta_robots_index')[$langKey] == '1') {
                $index = 'index, ';
            } else {
                $index = 'noindex, ';
            }

            if ($request->get('meta_robots_follow')[$langKey] == '1') {
                $follow = 'follow';
            } else {
                $follow = 'nofollow';
            }

            $meta[$langKey]['robots'] = $index.$follow;
            $meta[$langKey]['googlebots'] = $index.$follow;

            $count = count($request->get('meta_key')[$langKey]);
            for ($i = 0; $i < $count; $i++) {
                if (!is_null($request->get('meta_value')[$langKey][$i])) {
                    $meta[$langKey][$request->get('meta_key')[$langKey][$i]] = $request->get('meta_value')[$langKey][$i];
                }
            }
        }
        $page->meta = $meta;

        $page->template_id = $request['template_id'];
        $page->page = $request['page'];
        $page->active = $request['active'];
        $page->isHp = $request['isHp'];
        $page->roles = count(is_array($request['roles']) ? $request['roles'] : []) > 0 ? implode('|', $request['roles']) : null;

        $page->css = $request->get('css');
        $page->js = $request->get('js');

        $page->save();
    }
}
