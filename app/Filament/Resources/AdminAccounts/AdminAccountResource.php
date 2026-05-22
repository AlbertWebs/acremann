<?php

namespace App\Filament\Resources\AdminAccounts;

use App\Filament\Concerns\ChecksAdminRole;
use App\Filament\Resources\AdminAccounts\Pages\CreateAdminAccount;
use App\Filament\Resources\AdminAccounts\Pages\EditAdminAccount;
use App\Filament\Resources\AdminAccounts\Pages\ListAdminAccounts;
use App\Filament\Resources\AdminAccounts\Schemas\AdminAccountForm;
use App\Filament\Resources\AdminAccounts\Tables\AdminAccountsTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AdminAccountResource extends Resource
{
    use ChecksAdminRole;

    protected static function requiresSuperAdminAccess(): bool
    {
        return true;
    }

    protected static ?string $model = User::class;

    protected static ?string $slug = 'admin-accounts';

    protected static ?string $navigationLabel = 'Admin accounts';

    protected static ?string $modelLabel = 'admin account';

    protected static ?string $pluralModelLabel = 'admin accounts';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 100;

    public static function form(Schema $schema): Schema
    {
        return AdminAccountForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminAccountsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminAccounts::route('/'),
            'create' => CreateAdminAccount::route('/create'),
            'edit' => EditAdminAccount::route('/{record}/edit'),
        ];
    }
}
