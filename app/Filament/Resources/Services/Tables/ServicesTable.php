<?php

namespace App\Filament\Resources\Services\Tables;

use App\Filament\Support\TableActions;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Card image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('title')
                    ->searchable()
                    ->description(fn ($record): ?string => $record->plainSummary() ?: null)
                    ->grow()
                    ->wrap(),
                TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                ImageColumn::make('header_image')
                    ->label('Page header')
                    ->disk('public')
                    ->toggleable(),
                TextColumn::make('icon')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                TableActions::edit(),
                Action::make('view')
                    ->label('Live')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn ($record): string => route('services.show', $record->slug), shouldOpenInNewTab: true)
                    ->visible(fn ($record): bool => $record->is_published && filled($record->slug)),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
