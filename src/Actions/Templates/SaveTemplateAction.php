<?php

namespace Chuckbe\Chuckcms\Actions\Templates;

use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Requests\Templates\SaveTemplateRequest;

class SaveTemplateAction
{
    public function __invoke(SaveTemplateRequest $request): Template
    {
        $template = Template::where('id', $request->input('template_id'))->first();

        $template->name = $request->input('template_name');
        $template->fonts = ['raw' => $request->input('template_fonts')];
        $template->css = $this->buildAssetMap($request->input('css_slug', []), $request->input('css_href', []), $request->input('css_asset', []));
        $template->js = $this->buildAssetMap($request->input('js_slug', []), $request->input('js_href', []), $request->input('js_asset', []));
        $template->json = $this->mergeJsonValues($template->json, $request->input('json_slug', []));

        $template->update();

        return $template;
    }

    /**
     * Build the { slug => { href, asset } } map used for both css and js
     * asset declarations on a template. Keeps the original 'true'/'false'
     * string sentinels for asset-mode to avoid changing persisted shape.
     */
    private function buildAssetMap(array $slugs, array $hrefs, array $assets): array
    {
        $map = [];
        $count = count($slugs);
        for ($i = 0; $i < $count; $i++) {
            $map[$slugs[$i]] = [
                'href'  => $hrefs[$i] ?? null,
                'asset' => ($assets[$i] ?? null) == 1 ? 'true' : 'false',
            ];
        }

        return $map;
    }

    /**
     * Overlay updated values onto the template's existing json settings
     * array. Keys absent from the request pass through untouched.
     */
    private function mergeJsonValues(?array $existing, array $updates): ?array
    {
        if ($existing === null || count($existing) === 0) {
            return $existing;
        }

        foreach ($updates as $key => $value) {
            $existing[$key]['value'] = $value;
        }

        return $existing;
    }
}
