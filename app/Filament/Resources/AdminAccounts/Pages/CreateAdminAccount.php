<?php

namespace App\Filament\Resources\AdminAccounts\Pages;

use App\Filament\Resources\AdminAccounts\AdminAccountResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdminAccount extends CreateRecord
{
    protected static string $resource = AdminAccountResource::class;
}
