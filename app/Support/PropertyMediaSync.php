<?php

namespace App\Support;

use App\Models\Property;
use Illuminate\Support\Facades\Storage;

class PropertyMediaSync
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function fillFormMedia(Property $property, array $data): array
    {
        $hero = $property->getFirstMedia('hero');
        $data['hero_image'] = $hero
            ? PublicStorage::normalizePath($hero->getPathRelativeToRoot())
            : null;

        $data['gallery_images'] = $property->getMedia('gallery')
            ->sortBy('order_column')
            ->map(fn ($media) => PublicStorage::normalizePath($media->getPathRelativeToRoot()))
            ->filter()
            ->values()
            ->all();

        return $data;
    }

    public static function syncHero(Property $property, mixed $hero): void
    {
        $path = static::normalizeUploadValue($hero);

        if ($path === null) {
            $property->clearMediaCollection('hero');

            return;
        }

        $existing = $property->getFirstMedia('hero');
        if ($existing && PublicStorage::normalizePath($existing->getPathRelativeToRoot()) === $path) {
            return;
        }

        $property->clearMediaCollection('hero');

        if (Storage::disk('public')->exists($path)) {
            $property->addMediaFromDisk($path, 'public')
                ->preservingOriginal()
                ->toMediaCollection('hero');
        }
    }

    /**
     * @param  list<string>|array<int, mixed>|null  $paths
     */
    public static function syncGallery(Property $property, ?array $paths): void
    {
        $paths = PublicStorage::normalizePaths($paths);

        foreach ($property->getMedia('gallery') as $media) {
            $path = PublicStorage::normalizePath($media->getPathRelativeToRoot());
            if (! in_array($path, $paths, true)) {
                $media->delete();
            }
        }

        foreach ($paths as $position => $path) {
            $media = $property->getMedia('gallery')
                ->first(fn ($item) => PublicStorage::normalizePath($item->getPathRelativeToRoot()) === $path);

            if (! $media) {
                if (! Storage::disk('public')->exists($path)) {
                    continue;
                }

                $media = $property->addMediaFromDisk($path, 'public')
                    ->preservingOriginal()
                    ->toMediaCollection('gallery');
            }

            $order = $position + 1;
            if ((int) $media->order_column !== $order) {
                $media->order_column = $order;
                $media->save();
            }
        }
    }

    public static function sync(Property $property, mixed $hero, ?array $gallery): void
    {
        static::syncHero($property, $hero);
        static::syncGallery($property, $gallery);
    }

    public static function normalizeUploadValue(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value[0] ?? null;
        }

        return PublicStorage::normalizePath(is_string($value) ? $value : null);
    }
}
