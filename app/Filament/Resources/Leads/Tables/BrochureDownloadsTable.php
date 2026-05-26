<?php

namespace App\Filament\Resources\Leads\Tables;

use App\Filament\Support\TableActions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BrochureDownloadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('property.title')
                    ->label('Property')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                IconColumn::make('consent_email')
                    ->label('Email consent')
                    ->boolean(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted' => 'info',
                        'converted' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('property')
                    ->relationship('property', 'title')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'converted' => 'Converted',
                    ]),
            ])
            ->recordActions([
                TableActions::edit(),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
