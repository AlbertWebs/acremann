<?php

namespace App\Filament\Resources\AdminAccounts\Pages;

use App\Filament\Resources\AdminAccounts\AdminAccountResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminAccounts extends ListRecords
{
    protected static string $resource = AdminAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
