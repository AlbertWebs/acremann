<?php

namespace App\Filament\Resources\ClientLookups;

use App\Filament\Resources\ClientLookups\Pages\CreateClientLookup;
use App\Filament\Resources\ClientLookups\Pages\EditClientLookup;
use App\Filament\Resources\ClientLookups\Pages\ListClientLookups;
use App\Filament\Resources\ClientLookups\Schemas\ClientLookupForm;
use App\Filament\Resources\ClientLookups\Tables\ClientLookupsTable;
use App\Filament\Resources\Finance\FinanceResource;
use App\Models\ClientLookup;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientLookupResource extends FinanceResource
{
    protected static ?string $model = ClientLookup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static ?string $navigationLabel = 'Client portal lookups';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ClientLookupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientLookupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientLookups::route('/'),
            'create' => CreateClientLookup::route('/create'),
            'edit' => EditClientLookup::route('/{record}/edit'),
        ];
    }
}
