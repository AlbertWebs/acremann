<?php

namespace App\Filament\Resources\ClientLookups\Pages;

use App\Filament\Resources\ClientLookups\ClientLookupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClientLookup extends EditRecord
{
    protected static string $resource = ClientLookupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
