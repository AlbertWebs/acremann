<?php

namespace App\Filament\Resources\ClientLookups\Tables;

use App\Enums\ClientLookupType;
use App\Filament\Support\TableActions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClientLookupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('reference_number')
            ->columns([
                TextColumn::make('reference_number')
                    ->label('Reference')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('lookup_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (ClientLookupType $state): string => $state->label())
                    ->color(fn (ClientLookupType $state): string => match ($state) {
                        ClientLookupType::Title => 'success',
                        ClientLookupType::Payment => 'info',
                    }),
                TextColumn::make('client_name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('client_phone')
                    ->label('Phone')
                    ->toggleable(),
                TextColumn::make('client_email')
                    ->label('Email')
                    ->toggleable(),
                TextColumn::make('statement_path')
                    ->label('PDF')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Uploaded' : '—')
                    ->toggleable(),
                TextColumn::make('status_message')
                    ->limit(40)
                    ->wrap()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('lookup_type')
                    ->label('Type')
                    ->options(collect(ClientLookupType::cases())->mapWithKeys(
                        fn (ClientLookupType $type): array => [$type->value => $type->label()]
                    )),
            ])
            ->recordActions([
                TableActions::edit(),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
