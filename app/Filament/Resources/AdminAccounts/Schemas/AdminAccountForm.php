<?php

namespace App\Filament\Resources\AdminAccounts\Schemas;

use App\Enums\AdminRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class AdminAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Select::make('admin_role')
                    ->label('Role')
                    ->options(collect(AdminRole::cases())->mapWithKeys(
                        fn (AdminRole $role): array => [$role->value => $role->label()]
                    ))
                    ->default(AdminRole::SuperAdmin->value)
                    ->required()
                    ->native(false)
                    ->helperText('Super admins can access all areas including Finance. Normal admins cannot access Finance.'),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->rule(Password::default())
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255),
            ]);
    }
}
