<?php

namespace App\Filament\Resources\Testimonials\Tables;

use App\Filament\Support\TableActions;
use App\Support\PublicStorage;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Photo')
                    ->disk('public')
                    ->getStateUsing(fn ($record): ?string => PublicStorage::normalizePath($record->photo_path))
                    ->toggleable(),
                TextColumn::make('client_name')
                    ->searchable(),
                TextColumn::make('client_detail')
                    ->searchable(),
                TextColumn::make('property.title')
                    ->searchable(),
                IconColumn::make('is_featured')
                    ->boolean(),
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
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
