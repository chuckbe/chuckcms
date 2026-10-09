<?php

namespace Chuckbe\Chuckcms\Actions\Pages;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Requests\Pages\SavePageRequest;

class CreatePageAction
{
    public function __construct(private BuildPageMetaAction $buildPageMeta)
    {
    }

    public function __invoke(SavePageRequest $request): Page
    {
        $page = new Page();
        $page->meta = ($this->buildPageMeta)($page, $request, skipNullMetaValues: false);

        $page->template_id = $request['template_id'];
        $page->page = $request['page'];
        $page->active = $request['active'];
        $page->isHp = $request['isHp'];
        $page->order = (Page::max('order') ?? 0) + 1;
        $page->css = $request->get('css');
        $page->js = $request->get('js');

        $page->save();

        return $page;
    }
}
