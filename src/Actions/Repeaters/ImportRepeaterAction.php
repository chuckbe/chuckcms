<?php

namespace Chuckbe\Chuckcms\Actions\Repeaters;

use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Requests\Content\ImportRepeaterRequest;
use Illuminate\Validation\ValidationException;

class ImportRepeaterAction
{
    /**
     * Required structure of the JSON import payload, in dot-notation.
     * Missing any of these raises a ValidationException.
     */
    private const REQUIRED_KEYS = [
        'type',
        'content',
        'content.fields',
        'content.actions',
        'content.files',
    ];

    public function __invoke(ImportRepeaterRequest $request): Content
    {
        $newSlug = $request->input('slug');
        $payload = $this->decodeRemapped($request, $newSlug);

        $this->validateShape($payload);

        return Content::updateOrCreate(
            ['id' => null],
            [
                'slug'    => $newSlug,
                'type'    => $payload['type'],
                'content' => $payload['content'],
            ],
        );
    }

    /**
     * Load the uploaded JSON file and rewrite any occurrence of the
     * source slug with the destination slug before decoding. Matches
     * the original one-shot str_replace strategy so existing export
     * files still round-trip cleanly.
     */
    private function decodeRemapped(ImportRepeaterRequest $request, string $newSlug): array
    {
        $raw = file_get_contents($request->file('file')->getRealPath());
        $oldSlug = json_decode($raw, true)['slug'] ?? '';

        $remapped = str_replace($oldSlug, $newSlug, $raw);

        return (array) json_decode($remapped, true);
    }

    /**
     * Collapse the five hand-rolled array_key_exists checks on the
     * original controller into a single loop, throwing a
     * ValidationException with the same per-key "key X was not
     * present" message Laravel will render as a flash notification.
     */
    private function validateShape(array $payload): void
    {
        foreach (self::REQUIRED_KEYS as $dottedKey) {
            if (!$this->hasDotted($payload, $dottedKey)) {
                $leaf = explode('.', $dottedKey);
                throw ValidationException::withMessages([
                    'file' => sprintf('The "%s" key was not present in the JSON file.', end($leaf)),
                ]);
            }
        }
    }

    private function hasDotted(array $payload, string $dottedKey): bool
    {
        $parts = explode('.', $dottedKey);
        $cursor = $payload;
        foreach ($parts as $part) {
            if (!is_array($cursor) || !array_key_exists($part, $cursor)) {
                return false;
            }
            $cursor = $cursor[$part];
        }

        return true;
    }
}
