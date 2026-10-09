<?php

namespace Chuckbe\Chuckcms\Actions\Repeaters;

use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Requests\Content\DeleteRepeaterRequest;

class DeleteRepeaterAction
{
    /**
     * Delete the repeater definition (Content row) together with all
     * its stored entries (Repeater rows sharing the same slug).
     *
     * Returns the legacy 'success'/'error'/'false' tri-state string.
     */
    public function __invoke(DeleteRepeaterRequest $request): string
    {
        $content = Content::find($request->input('content_id'));
        if ($content === null) {
            return 'false';
        }

        Repeater::where('slug', $content->slug)->delete();

        return $content->delete() ? 'success' : 'error';
    }
}
