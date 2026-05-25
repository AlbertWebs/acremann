<?php

namespace App\Filament\Resources\Properties\Concerns;

use App\Models\Property;
use App\Support\PropertyMediaSync;

trait SyncsPropertyMediaForm
{
    protected mixed $pendingHeroImage = null;

    /** @var list<string> */
    protected array $pendingGalleryImages = [];

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        if ($record instanceof Property) {
            $data = PropertyMediaSync::fillFormMedia($record, $data);
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->pendingHeroImage = $data['hero_image'] ?? null;
        $this->pendingGalleryImages = is_array($data['gallery_images'] ?? null)
            ? $data['gallery_images']
            : [];

        unset($data['hero_image'], $data['gallery_images']);

        return $data;
    }

    protected function syncPropertyMediaAfterSave(): void
    {
        $record = $this->getRecord();

        if (! $record instanceof Property) {
            return;
        }

        PropertyMediaSync::sync($record, $this->pendingHeroImage, $this->pendingGalleryImages);
    }
}
