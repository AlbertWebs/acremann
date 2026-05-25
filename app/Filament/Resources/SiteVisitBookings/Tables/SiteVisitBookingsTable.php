<?php

namespace App\Filament\Resources\SiteVisitBookings\Tables;

use App\Enums\SiteVisitBookingStatus;
use App\Filament\Support\TableActions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SiteVisitBookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (SiteVisitBookingStatus $state): string => $state->label())
                    ->color(fn (SiteVisitBookingStatus $state): string => $state->color()),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('property.title')
                    ->label('Property')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('property_interest')
                    ->label('Area / project')
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('message')
                    ->label('Preferred date & notes')
                    ->limit(40)
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(collect(SiteVisitBookingStatus::cases())->mapWithKeys(
                        fn (SiteVisitBookingStatus $status): array => [$status->value => $status->label()]
                    )),
            ])
            ->recordActions([
                TableActions::edit(),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
