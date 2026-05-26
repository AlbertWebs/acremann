<?php

namespace App\Support;

class PublicStorage
{
    /**
     * Strip host and /storage prefix so only the disk path remains (e.g. hero/file.jpg).
     */
    public static function normalizePath(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            $path = parse_url($path, PHP_URL_PATH) ?? $path;
        }

        $path = preg_replace('#^/?storage/#', '', $path);

        return ltrim($path, '/');
    }

    /**
     * Root-relative URL for the current host (localhost, staging, production).
     */
    public static function url(?string $path): ?string
    {
        $path = static::normalizePath($path);

        if ($path === null) {
            return null;
        }

        return '/storage/'.$path;
    }

    /**
     * Full URL for the current request host (e.g. http://localhost:8000/storage/...).
     */
    public static function absoluteUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $relative = str_starts_with($path, '/') ? $path : static::url($path);

        if ($relative === null) {
            return null;
        }

        if (! app()->runningInConsole() && request()->getHost()) {
            return request()->getSchemeAndHttpHost().$relative;
        }

        return url($relative);
    }

    /**
     * @param  list<string>|array<int, mixed>|null  $paths
     * @return list<string>
     */
    public static function normalizePaths(?array $paths): array
    {
        if ($paths === null) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn (mixed $path): ?string => is_string($path) ? static::normalizePath($path) : null,
            $paths,
        )));
    }
}
