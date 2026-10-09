<?php

namespace Chuckbe\Chuckcms\Actions\Resources;

use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Requests\Content\DeleteResourceRequest;

class DeleteResourceAction
{
    public function __invoke(DeleteResourceRequest $request): string
    {
        $resource = Resource::find($request->input('resource_id'));
        if ($resource === null) {
            return 'false';
        }

        return $resource->delete() ? 'success' : 'error';
    }
}
