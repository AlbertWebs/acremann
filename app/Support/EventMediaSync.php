<?php

namespace App\Support;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventMediaSync
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function fillFormMedia(Event $event, array $data): array
    {
        $cover = $event->getFirstMedia('cover');
        $data['cover_image'] = $cover
            ? PublicStorage::normalizePath($cover->getPathRelativeToRoot())
            : null;

        $data['gallery_images'] = $event->getMedia('gallery')
            ->sortBy('order_column')
            ->map(fn ($media) => PublicStorage::normalizePath($media->getPathRelativeToRoot()))
            ->filter()
            ->values()
            ->all();

        return $data;
    }

    public static function syncCover(Event $event, mixed $cover): void
    {
        $path = static::normalizeUploadValue($cover);

        if ($path === null) {
            $event->clearMediaCollection('cover');

            return;
        }

        $existing = $event->getFirstMedia('cover');
        if ($existing && PublicStorage::normalizePath($existing->getPathRelativeToRoot()) === $path) {
            return;
        }

        $event->clearMediaCollection('cover');

        if (Storage::disk('public')->exists($path)) {
            $event->addMediaFromDisk($path, 'public')
                ->preservingOriginal()
                ->toMediaCollection('cover');
        }
    }

    /**
     * @param  list<string>|array<int, mixed>|null  $paths
     */
    public static function syncGallery(Event $event, ?array $paths): void
    {
        $paths = PublicStorage::normalizePaths($paths);

        foreach ($event->getMedia('gallery') as $media) {
            $path = PublicStorage::normalizePath($media->getPathRelativeToRoot());
            if (! in_array($path, $paths, true)) {
                $media->delete();
            }
        }

        foreach ($paths as $position => $path) {
            $media = $event->getMedia('gallery')
                ->first(fn ($item) => PublicStorage::normalizePath($item->getPathRelativeToRoot()) === $path);

            if (! $media) {
                if (! Storage::disk('public')->exists($path)) {
                    continue;
                }

                $media = $event->addMediaFromDisk($path, 'public')
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

    public static function sync(Event $event, mixed $cover, ?array $gallery): void
    {
        static::syncCover($event, $cover);
        static::syncGallery($event, $gallery);
    }

    public static function normalizeUploadValue(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value[0] ?? null;
        }

        return PublicStorage::normalizePath(is_string($value) ? $value : null);
    }
}
