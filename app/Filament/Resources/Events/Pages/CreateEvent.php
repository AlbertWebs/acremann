<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\Concerns\SyncsEventMediaForm;
use App\Filament\Resources\Events\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    use SyncsEventMediaForm;

    protected static string $resource = EventResource::class;

    protected function afterCreate(): void
    {
        $this->syncEventMediaAfterSave();
    }
}
