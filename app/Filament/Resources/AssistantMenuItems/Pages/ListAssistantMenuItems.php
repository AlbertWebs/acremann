<?php

namespace App\Filament\Resources\AssistantMenuItems\Pages;

use App\Filament\Resources\AssistantMenuItems\AssistantMenuItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssistantMenuItems extends ListRecords
{
    protected static string $resource = AssistantMenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
