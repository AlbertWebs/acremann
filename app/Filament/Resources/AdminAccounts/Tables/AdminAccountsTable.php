<?php

namespace App\Filament\Resources\AdminAccounts\Tables;

use App\Enums\AdminRole;
use App\Filament\Support\TableActions;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminAccountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('admin_role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn (AdminRole $state): string => $state->label())
                    ->color(fn (AdminRole $state): string => match ($state) {
                        AdminRole::SuperAdmin => 'success',
                        AdminRole::Admin => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                TableActions::edit(),
                TableActions::delete()
                    ->before(function (User $record): void {
                        if ($record->isSuperAdmin() && User::query()->where('admin_role', AdminRole::SuperAdmin)->count() <= 1) {
                            throw new \RuntimeException('You cannot delete the only super admin account.');
                        }
                    }),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
