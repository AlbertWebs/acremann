<?php

namespace App\Filament\Resources\AssistantSessions;

use App\Filament\Resources\AssistantSessions\Pages\ListAssistantSessions;
use App\Filament\Resources\AssistantSessions\Pages\ViewAssistantSession;
use App\Filament\Resources\AssistantSessions\Schemas\AssistantSessionInfolist;
use App\Filament\Resources\AssistantSessions\Tables\AssistantSessionsTable;
use App\Models\AssistantSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AssistantSessionResource extends Resource
{
    protected static ?string $model = AssistantSession::class;

    protected static ?string $navigationLabel = 'Conversations';

    protected static string|UnitEnum|null $navigationGroup = 'Acremann Assistant';

    protected static ?string $modelLabel = 'assistant conversation';

    protected static ?string $pluralModelLabel = 'assistant conversations';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssistantSessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssistantSessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssistantSessions::route('/'),
            'view' => ViewAssistantSession::route('/{record}'),
        ];
    }
}
