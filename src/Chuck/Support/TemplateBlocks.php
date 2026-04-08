<?php

namespace Chuckbe\Chuckcms\Chuck\Support;

class TemplateBlocks
{
    /**
     * Recursively scan a template's blocks directory and return a nested
     * array describing every .html block file, the path to its preview
     * image (if any), and a human-readable name.
     *
     * Output shape (per leaf):
     *   [
     *     'name'     => 'header logo',
     *     'location' => '/path/to/template/blocks/header-logo.html',
     *     'img'      => '/path/to/preview.jpg' | fallback URL,
     *   ]
     */
    public static function scan(string $dir): array
    {
        if (!is_dir($dir)) {
            return [];
        }

        $result = [];
        foreach (scandir($dir) as $value) {
            if ($value === '.' || $value === '..' || $value === '.DS_Store') {
                continue;
            }

            $fullPath = $dir.DIRECTORY_SEPARATOR.$value;

            if (is_dir($fullPath)) {
                $result[$value] = self::scan($fullPath);
                continue;
            }

            if (strpos($value, '.html') === false) {
                continue;
            }

            $blockKey = str_replace('.html', '', $value);
            $blockName = str_replace('-', ' ', $blockKey);
            $result[$blockKey] = [
                'name'     => $blockName,
                'location' => $fullPath,
                'img'      => self::resolvePreviewImage($dir, $blockKey),
            ];
        }

        return $result;
    }

    private static function resolvePreviewImage(string $dir, string $blockKey): string
    {
        foreach (['jpg', 'jpeg', 'png'] as $ext) {
            $candidate = $dir.DIRECTORY_SEPARATOR.$blockKey.'.'.$ext;
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        return 'https://ui-avatars.com/api/?length=5&size=150&name=BLOCK&background=0D8ABC&color=fff&font-size=0.2';
    }
}
