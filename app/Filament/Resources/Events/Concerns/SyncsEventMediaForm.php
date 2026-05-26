<?php

namespace App\Filament\Resources\Events\Concerns;

use App\Models\Event;
use App\Support\EventMediaSync;

trait SyncsEventMediaForm
{
    protected mixed $pendingCoverImage = null;

    /** @var list<string> */
    protected array $pendingGalleryImages = [];

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        if ($record instanceof Event) {
            $data = EventMediaSync::fillFormMedia($record, $data);
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->pendingCoverImage = $data['cover_image'] ?? null;
        $this->pendingGalleryImages = is_array($data['gallery_images'] ?? null)
            ? $data['gallery_images']
            : [];

        unset($data['cover_image'], $data['gallery_images']);

        return $data;
    }

    protected function syncEventMediaAfterSave(): void
    {
        $record = $this->getRecord();

        if (! $record instanceof Event) {
            return;
        }

        EventMediaSync::sync($record, $this->pendingCoverImage, $this->pendingGalleryImages);
    }
}
