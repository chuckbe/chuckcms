<?php

namespace Chuckbe\Chuckcms\Actions\Resources;

use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Requests\Content\SaveResourceRequest;
use ChuckSite;

class SaveResourceAction
{
    public function __invoke(SaveResourceRequest $request): Resource
    {
        $slug = $request->input('slug')[0];
        $resource = Resource::firstOrNew(['slug' => $slug]);
        $resource->slug = $slug;
        $resource->json = $this->buildLocalisedJson($request);
        $resource->save();

        return $resource;
    }

    /**
     * Build the per-locale { key => value } map from the parallel
     * resource_key[locale][] and resource_value[locale][] arrays.
     */
    private function buildLocalisedJson(SaveResourceRequest $request): array
    {
        $json = [];
        foreach (ChuckSite::getSupportedLocales() as $langKey => $langValue) {
            $keys = $request->input('resource_key')[$langKey] ?? [];
            $values = $request->input('resource_value')[$langKey] ?? [];
            $count = count($keys);
            for ($i = 0; $i < $count; $i++) {
                $json[$langKey][$keys[$i]] = $values[$i];
            }
        }

        return $json;
    }
}
