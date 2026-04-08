<?php

namespace Chuckbe\Chuckcms\Actions\Repeaters;

use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Requests\Repeaters\DeleteRepeaterEntryRequest;

class DeleteRepeaterEntryAction
{
    public function __invoke(DeleteRepeaterEntryRequest $request): string
    {
        $repeater = Repeater::find($request->input('repeater_id'));
        if ($repeater === null) {
            return 'false';
        }

        return $repeater->delete() ? 'success' : 'error';
    }
}
