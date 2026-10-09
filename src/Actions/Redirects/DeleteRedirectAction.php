<?php

namespace Chuckbe\Chuckcms\Actions\Redirects;

use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Requests\Redirects\DeleteRedirectRequest;

class DeleteRedirectAction
{
    public function __invoke(DeleteRedirectRequest $request): void
    {
        Redirect::where('id', $request->input('id'))->delete();
    }
}
