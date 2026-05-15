<?php

namespace App\Filament\Resources\ClientLookups\Pages;

use App\Filament\Resources\ClientLookups\ClientLookupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientLookups extends ListRecords
{
    protected static string $resource = ClientLookupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
