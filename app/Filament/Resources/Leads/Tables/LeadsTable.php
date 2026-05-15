<?php

namespace App\Filament\Resources\Leads\Tables;

use App\Filament\Support\TableActions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable()
                    ->grow()
                    ->wrap(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('property.title')
                    ->searchable(),
                TextColumn::make('buyer_type')
                    ->searchable(),
                TextColumn::make('budget')
                    ->searchable(),
                TextColumn::make('location_preference')
                    ->searchable(),
                TextColumn::make('property_interest')
                    ->searchable(),
                IconColumn::make('consent_callback')
                    ->boolean(),
                IconColumn::make('consent_whatsapp')
                    ->boolean(),
                IconColumn::make('consent_email')
                    ->boolean(),
                IconColumn::make('consent_marketing')
                    ->boolean(),
                TextColumn::make('status')
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
                TableActions::edit(),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
