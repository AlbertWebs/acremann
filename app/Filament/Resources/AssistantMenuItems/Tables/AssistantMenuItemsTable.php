<?php

namespace App\Filament\Resources\AssistantMenuItems\Tables;

use App\Filament\Support\TableActions;
use App\Models\AssistantMenuItem;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssistantMenuItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('label')
                    ->searchable()
                    ->grow(),
                TextColumn::make('action')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        AssistantMenuItem::ACTION_FAQ => 'FAQs',
                        AssistantMenuItem::ACTION_TITLE => 'Title info',
                        AssistantMenuItem::ACTION_LEAD => 'Contact form',
                        AssistantMenuItem::ACTION_WHATSAPP => 'WhatsApp',
                        AssistantMenuItem::ACTION_LINK => 'Link',
                        default => $state,
                    }),
                TextColumn::make('journey')
                    ->placeholder('—')
                    ->toggleable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Live'),
            ])
            ->recordActions([
                TableActions::edit(),
                TableActions::delete(),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
