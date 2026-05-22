<?php

namespace App\Filament\Resources\AdminAccounts\Pages;

use App\Enums\AdminRole;
use App\Filament\Resources\AdminAccounts\AdminAccountResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAdminAccount extends EditRecord
{
    protected static string $resource = AdminAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function (User $record): void {
                    if ($record->isSuperAdmin() && User::query()->where('admin_role', AdminRole::SuperAdmin)->count() <= 1) {
                        throw new \RuntimeException('You cannot delete the only super admin account.');
                    }
                }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var User $record */
        if (
            $record->isSuperAdmin()
            && ($data['admin_role'] ?? $record->admin_role) !== AdminRole::SuperAdmin
            && User::query()->where('admin_role', AdminRole::SuperAdmin)->whereKeyNot($record->getKey())->count() === 0
        ) {
            throw new \RuntimeException('You cannot demote the only super admin account.');
        }

        return parent::handleRecordUpdate($record, $data);
    }
}
