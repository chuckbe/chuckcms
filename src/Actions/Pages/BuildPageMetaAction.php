<?php

namespace Chuckbe\Chuckcms\Actions\Pages;

use Chuckbe\Chuckcms\Models\Page;
use ChuckSite;
use Illuminate\Http\Request;

/**
 * Shared helper for Create/Update page actions: walks every supported
 * locale, sets the translatable title/slug on the given Page, and
 * returns the fully-assembled meta array ready to be assigned to
 * $page->meta.
 *
 * The $skipNullMetaValues flag matches the only behavioural
 * difference between the old PageRepository::create() (kept nulls)
 * and PageRepository::updatePage() (skipped nulls).
 */
class BuildPageMetaAction
{
    public function __invoke(Page $page, Request $request, bool $skipNullMetaValues = false): array
    {
        $meta = [];
        foreach (ChuckSite::getSupportedLocales() as $langKey => $langValue) {
            $page->setTranslation('title', $langKey, $request->get('page_title')[$langKey]);
            $page->setTranslation('slug', $langKey, $request->get('page_slug')[$langKey]);

            $meta[$langKey] = $this->buildLocaleMeta($request, $langKey, $skipNullMetaValues);
        }

        return $meta;
    }

    private function buildLocaleMeta(Request $request, string $langKey, bool $skipNullMetaValues): array
    {
        $title = $request->get('meta_title')[$langKey];
        $description = $request->get('meta_description')[$langKey];
        $robots = $this->robotsDirective($request, $langKey);

        $meta = [
            'title'         => $title,
            'description'   => $description,
            'keywords'      => $request->get('meta_keywords')[$langKey],
            'og:url'        => $request->get('page_slug')[$langKey],
            'og:type'       => 'website',
            'og:title'      => $title,
            'og:description'=> $description,
            'og:site_name'  => $title,
            'og:image'      => $request->get('meta_image'),
            'robots'        => $robots,
            'googlebots'    => $robots,
        ];

        $keys = $request->get('meta_key')[$langKey];
        $values = $request->get('meta_value')[$langKey];
        $count = count($keys);
        for ($i = 0; $i < $count; $i++) {
            if ($skipNullMetaValues && is_null($values[$i])) {
                continue;
            }
            $meta[$keys[$i]] = $values[$i];
        }

        return $meta;
    }

    private function robotsDirective(Request $request, string $langKey): string
    {
        $index = $request->get('meta_robots_index')[$langKey] == '1' ? 'index, ' : 'noindex, ';
        $follow = $request->get('meta_robots_follow')[$langKey] == '1' ? 'follow' : 'nofollow';

        return $index.$follow;
    }
}
