<?php

namespace Chuckbe\Chuckcms\Chuck\Support;

class TagParser
{
    /**
     * Return every substring sandwiched between matching $startDelimiter
     * and $endDelimiter occurrences in $str. Identical semantics to the
     * three copies that previously lived in Models\\Form, Models\\Content
     * and Chuck\\PageBlockRepository.
     *
     * @return string[]
     */
    public static function between(string $str, string $startDelimiter, string $endDelimiter): array
    {
        $contents = [];
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = 0;

        while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($str, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }

        return $contents;
    }
}
