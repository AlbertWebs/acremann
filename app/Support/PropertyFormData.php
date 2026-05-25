<?php

namespace App\Support;

class PropertyFormData
{
    /**
     * @return list<string>|null
     */
    public static function linesToList(mixed $state): ?array
    {
        if ($state === null || $state === '') {
            return null;
        }

        if (is_array($state)) {
            return array_values(array_filter(array_map(
                fn (mixed $line): string => is_string($line) ? trim($line) : '',
                $state,
            )));
        }

        if (! is_string($state)) {
            return null;
        }

        return array_values(array_filter(array_map(
            trim(...),
            preg_split('/\r\n|\r|\n/', $state) ?: [],
        )));
    }

    public static function listToLines(mixed $state): ?string
    {
        if ($state === null || $state === []) {
            return null;
        }

        if (is_string($state)) {
            return $state;
        }

        if (! is_array($state)) {
            return null;
        }

        return implode("\n", array_values(array_filter(array_map(
            fn (mixed $line): string => is_string($line) ? trim($line) : (string) $line,
            $state,
        ))));
    }
}
