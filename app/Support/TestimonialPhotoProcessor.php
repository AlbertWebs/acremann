<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Constraint;
use Spatie\Image\Image;
use Throwable;

class TestimonialPhotoProcessor
{
    /** @var list<int> */
    public const WIDTHS = [600, 1200];

    public const QUALITY = 88;

    public static function variantPath(?string $photoPath, int $width): ?string
    {
        $path = PublicStorage::normalizePath($photoPath);

        if ($path === null) {
            return null;
        }

        $info = pathinfo($path);
        $directory = ($info['dirname'] ?? '') !== '.' ? $info['dirname'].'/' : '';

        return $directory.$info['filename'].'-'.$width.'w.webp';
    }

    public static function process(?string $photoPath): void
    {
        $path = PublicStorage::normalizePath($photoPath);

        if ($path === null || ! Storage::disk('public')->exists($path)) {
            return;
        }

        $sourcePath = Storage::disk('public')->path($path);

        foreach (self::WIDTHS as $width) {
            self::writeVariant($sourcePath, $path, $width);
        }
    }

    /**
     * @return list<string>
     */
    public static function existingVariantPaths(?string $photoPath): array
    {
        $paths = [];

        foreach (self::WIDTHS as $width) {
            $variant = self::variantPath($photoPath, $width);

            if ($variant !== null && Storage::disk('public')->exists($variant)) {
                $paths[] = $variant;
            }
        }

        return $paths;
    }

    public static function deleteVariants(?string $photoPath): void
    {
        foreach (self::WIDTHS as $width) {
            $variant = self::variantPath($photoPath, $width);

            if ($variant !== null && Storage::disk('public')->exists($variant)) {
                Storage::disk('public')->delete($variant);
            }
        }
    }

    private static function writeVariant(string $sourcePath, string $relativePath, int $width): void
    {
        $variantPath = self::variantPath($relativePath, $width);

        if ($variantPath === null) {
            return;
        }

        $destination = Storage::disk('public')->path($variantPath);

        try {
            Image::load($sourcePath)
                ->width($width, [Constraint::PreserveAspectRatio, Constraint::DoNotUpsize])
                ->quality(self::QUALITY)
                ->format('webp')
                ->optimize()
                ->save($destination);
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
