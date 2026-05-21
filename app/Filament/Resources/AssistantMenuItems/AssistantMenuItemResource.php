<?php

namespace App\Filament\Resources\AssistantMenuItems;

use App\Filament\Resources\AssistantMenuItems\Pages\CreateAssistantMenuItem;
use App\Filament\Resources\AssistantMenuItems\Pages\EditAssistantMenuItem;
use App\Filament\Resources\AssistantMenuItems\Pages\ListAssistantMenuItems;
use App\Filament\Resources\AssistantMenuItems\Schemas\AssistantMenuItemForm;
use App\Filament\Resources\AssistantMenuItems\Tables\AssistantMenuItemsTable;
use App\Models\AssistantMenuItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AssistantMenuItemResource extends Resource
{
    protected static ?string $model = AssistantMenuItem::class;

    protected static ?string $navigationLabel = 'Menu buttons';

    protected static ?string $modelLabel = 'menu button';

    protected static ?string $pluralModelLabel = 'menu buttons';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBars3BottomLeft;

    protected static string|UnitEnum|null $navigationGroup = 'Acremann Assistant';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return AssistantMenuItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssistantMenuItemsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssistantMenuItems::route('/'),
            'create' => CreateAssistantMenuItem::route('/create'),
            'edit' => EditAssistantMenuItem::route('/{record}/edit'),
        ];
    }
}
