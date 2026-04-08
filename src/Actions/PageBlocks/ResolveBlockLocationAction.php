<?php

namespace Chuckbe\Chuckcms\Actions\PageBlocks;

use Chuckbe\Chuckcms\Models\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Validate a user-supplied block location against the active
 * templates' blocks/ directories and return the canonicalised path.
 *
 * Phase 1 introduced this guard inline on PageBlockController to
 * close the LFI via add-block. Phase 2 moves it into a dedicated
 * action so the Add Top / Add Bottom actions both consume it.
 */
class ResolveBlockLocationAction
{
    public function __invoke(?string $location): string
    {
        if ($location === null || $location === '') {
            throw new NotFoundHttpException('Invalid block location.');
        }

        $real = realpath($location);
        if ($real === false || !is_file($real) || !str_ends_with($real, '.html')) {
            throw new NotFoundHttpException('Invalid block location.');
        }

        foreach (Template::where('active', 1)->get() as $template) {
            $allowed = realpath($template->path.DIRECTORY_SEPARATOR.'blocks');
            if ($allowed === false) {
                continue;
            }
            if (str_starts_with($real, $allowed.DIRECTORY_SEPARATOR)) {
                return $real;
            }
        }

        throw new NotFoundHttpException('Invalid block location.');
    }
}
