<?php

namespace App\Filament\Resources\Properties\Tables;

use App\Filament\Support\TableActions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->grow()
                    ->wrap(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('plot_availability')
                    ->label('Plots')
                    ->getStateUsing(fn ($record) => $record->availabilityDisplayLabel())
                    ->badge()
                    ->color(fn ($record) => $record->isSoldOut() ? 'danger' : 'success'),
                TextColumn::make('project_status')
                    ->searchable(),
                TextColumn::make('price_from')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price_label')
                    ->searchable(),
                TextColumn::make('plot_size')
                    ->searchable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('county')
                    ->searchable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('title_type')
                    ->searchable(),
                TextColumn::make('listing_type')
                    ->searchable(),
                TextColumn::make('tour_embed_url')
                    ->searchable(),
                TextColumn::make('brochure_path')
                    ->searchable(),
                IconColumn::make('is_featured')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('meta_title')
                    ->searchable(),
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
                TableActions::view(),
                TableActions::edit(),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
