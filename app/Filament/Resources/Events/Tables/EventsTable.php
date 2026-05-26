<?php

namespace App\Filament\Resources\Events\Tables;

use App\Filament\Support\TableActions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('event_date', 'desc')
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover')
                    ->disk('public')
                    ->visibility('public')
                    ->getStateUsing(fn ($record) => $record->adminCoverPath())
                    ->square(),
                TextColumn::make('title')
                    ->searchable()
                    ->grow()
                    ->wrap(),
                TextColumn::make('location')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('event_date')
                    ->label('Event date')
                    ->date()
                    ->sortable(),
                TextColumn::make('gallery_count')
                    ->label('Photos')
                    ->getStateUsing(fn ($record) => $record->getMedia('gallery')->count())
                    ->alignCenter(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                TableActions::edit(),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
