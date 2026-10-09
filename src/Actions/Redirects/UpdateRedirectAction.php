<?php

namespace Chuckbe\Chuckcms\Actions\Redirects;

use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Requests\Redirects\UpdateRedirectRequest;

class UpdateRedirectAction
{
    public function __invoke(UpdateRedirectRequest $request): void
    {
        Redirect::where('id', $request->input('id'))->update([
            'slug' => $request->input('slug'),
            'to'   => $request->input('to'),
            'type' => $request->input('type'),
        ]);
    }
}
