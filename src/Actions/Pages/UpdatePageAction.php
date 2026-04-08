<?php

namespace Chuckbe\Chuckcms\Actions\Pages;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Requests\Pages\SavePageRequest;

class UpdatePageAction
{
    public function __construct(private BuildPageMetaAction $buildPageMeta)
    {
    }

    public function __invoke(SavePageRequest $request): Page
    {
        $page = Page::findOrFail($request['page_id']);
        $page->meta = ($this->buildPageMeta)($page, $request, skipNullMetaValues: true);

        $page->template_id = $request['template_id'];
        $page->page = $request['page'];
        $page->active = $request['active'];
        $page->isHp = $request['isHp'];
        $page->roles = $this->rolesFromRequest($request['roles'] ?? null);
        $page->css = $request->get('css');
        $page->js = $request->get('js');

        $page->save();

        return $page;
    }

    /**
     * Join selected role ids with a '|' delimiter, or null if none
     * were selected. Matches the pre-existing storage format used by
     * FrontEndController::authorizedIndex().
     */
    private function rolesFromRequest(mixed $roles): ?string
    {
        if (!is_array($roles) || count($roles) === 0) {
            return null;
        }

        return implode('|', $roles);
    }
}
