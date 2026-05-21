<?php

namespace App\Filament\Resources\AssistantSessions\Pages;

use App\Filament\Resources\AssistantSessions\AssistantSessionResource;
use Filament\Resources\Pages\ListRecords;

class ListAssistantSessions extends ListRecords
{
    protected static string $resource = AssistantSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
