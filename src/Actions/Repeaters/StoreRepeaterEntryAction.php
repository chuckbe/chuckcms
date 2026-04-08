<?php

namespace Chuckbe\Chuckcms\Actions\Repeaters;

use Chuckbe\Chuckcms\Chuck\Support\TagParser;
use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Models\Repeater;
use Illuminate\Http\Request;

class StoreRepeaterEntryAction
{
    /**
     * Persist a single submitted repeater entry. The Content
     * definition is looked up by the content_slug posted in the form
     * and its per-field rules are assumed to have already passed via
     * StoreRepeaterEntryRequest before the action is invoked.
     */
    public function __invoke(Request $request): Repeater
    {
        $slug = $request->input('content_slug');
        $content = Content::where('slug', $slug)->firstOrFail();

        [$url, $page] = $this->resolveDetailRoute($content, $request);
        $json = $this->stripSlugPrefixFromKeys($content, $request);

        return Repeater::updateOrCreate(
            ['id' => $request->input('repeater_id')],
            [
                'slug' => $slug,
                'url'  => $url,
                'page' => $page,
                'json' => $json,
            ],
        );
    }

    /**
     * Decide the detail page and final URL for this entry. If the
     * content has a detail action with a url template, run the
     * placeholder substitution (same semantics as the old
     * Content::getUrlFromInput helper).
     */
    private function resolveDetailRoute(Content $content, Request $request): array
    {
        $detail = $content->content['actions']['detail'] ?? null;

        if (!is_array($detail) || !array_key_exists('url', $detail)) {
            return [null, 'default'];
        }

        return [$this->interpolateUrl($detail['url'], $request), $detail['page']];
    }

    private function interpolateUrl(string $template, Request $request): string
    {
        $fields = TagParser::between($template, '[', ']');
        foreach ($fields as $field) {
            $template = str_replace('['.$field.']', $request->input($field), $template);
        }

        return $template;
    }

    /**
     * Field keys in the form are namespaced as `{slug}_{name}` but
     * entries are stored unprefixed. This matches the legacy
     * Content::storeEntry() behaviour.
     */
    private function stripSlugPrefixFromKeys(Content $content, Request $request): array
    {
        $slug = $request->input('content_slug');
        $json = [];
        foreach ($content->content['fields'] as $fieldKey => $fieldValue) {
            $cleanKey = str_replace($slug.'_', '', $fieldKey);
            $json[$cleanKey] = $request->input($fieldKey);
        }

        return $json;
    }
}
