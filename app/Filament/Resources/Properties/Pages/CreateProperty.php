<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Filament\Resources\Properties\Concerns\SyncsPropertyMediaForm;
use App\Filament\Resources\Properties\PropertyResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateProperty extends CreateRecord
{
    use SyncsPropertyMediaForm;

    protected static string $resource = PropertyResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'New property';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Add listing details, photos, and publishing options. You can save as draft and publish when ready.';
    }

    protected function afterCreate(): void
    {
        $this->syncPropertyMediaAfterSave();
    }
}
