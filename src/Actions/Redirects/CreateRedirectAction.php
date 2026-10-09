<?php

namespace Chuckbe\Chuckcms\Actions\Redirects;

use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Requests\Redirects\CreateRedirectRequest;

class CreateRedirectAction
{
    public function __invoke(CreateRedirectRequest $request): Redirect
    {
        $redirect = Redirect::firstOrNew(
            ['slug' => $request->input('slug')],
            [
                'to'   => $request->input('to'),
                'type' => $request->input('type'),
            ]
        );

        $redirect->save();

        return $redirect;
    }
}
