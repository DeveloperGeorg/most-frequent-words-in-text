<?php

namespace TestTask;

/**
 * @param string $text
 * @param int $topCount
 *
 * @return array
 */
function findMostFrequentWordsInText(string $text, int $topCount = 1)
{
    $words = preg_split('/(\.\.\.\s?|[-.?!,;:(){}\[\]\'"]\s?)|\s/', $text, null, PREG_SPLIT_NO_EMPTY);

    $map = [];
    foreach ($words as $word) {
        $word = mb_strtolower($word);
        if (!isset($map[$word])) {
            $map[$word] = 0;
        }
        $map[$word]++;
    }
    arsort($map);

    return array_slice($map, 0, $topCount);
}
