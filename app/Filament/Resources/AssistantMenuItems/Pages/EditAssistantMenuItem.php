<?php

namespace App\Filament\Resources\AssistantMenuItems\Pages;

use App\Filament\Resources\AssistantMenuItems\AssistantMenuItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssistantMenuItem extends EditRecord
{
    protected static string $resource = AssistantMenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
