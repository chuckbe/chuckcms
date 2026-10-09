<?php

namespace Chuckbe\Chuckcms\Actions\PageBlocks;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Validate a user-supplied block location against the page's own
 * template blocks/ directory and return the canonicalised path.
 * Only .html files that physically live under that directory are
 * accepted, which guards against path traversal.
 */
class ResolveBlockLocationAction
{
    public function __invoke(mixed $location, Page $page): string
    {
        if (!is_string($location) || $location === '') {
            throw new NotFoundHttpException('Invalid block location.');
        }

        $real = realpath($location);
        if ($real === false || !is_file($real) || !str_ends_with($real, '.html')) {
            throw new NotFoundHttpException('Invalid block location.');
        }

        $template = Template::where('id', $page->template_id)->first();
        $allowed = $template ? realpath($template->path.DIRECTORY_SEPARATOR.'blocks') : false;
        if ($allowed === false || !str_starts_with($real, $allowed.DIRECTORY_SEPARATOR)) {
            throw new NotFoundHttpException('Invalid block location.');
        }

        return $real;
    }
}
