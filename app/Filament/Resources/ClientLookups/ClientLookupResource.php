<?php

namespace App\Filament\Resources\ClientLookups;

use App\Filament\Resources\ClientLookups\Pages\CreateClientLookup;
use App\Filament\Resources\ClientLookups\Pages\EditClientLookup;
use App\Filament\Resources\ClientLookups\Pages\ListClientLookups;
use App\Filament\Resources\ClientLookups\Schemas\ClientLookupForm;
use App\Filament\Resources\ClientLookups\Tables\ClientLookupsTable;
use App\Models\ClientLookup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ClientLookupResource extends Resource
{
    protected static ?string $model = ClientLookup::class;

    protected static ?string $navigationLabel = 'Client portal records';

    protected static ?string $modelLabel = 'client record';

    protected static ?string $pluralModelLabel = 'client portal records';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    protected static string|UnitEnum|null $navigationGroup = 'Client Portal';

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
