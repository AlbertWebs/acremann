<?php

namespace App\Filament\Resources\AssistantSessions\Tables;

use App\Filament\Support\TableActions;
use App\Models\AssistantSession;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AssistantSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('last_activity_at', 'desc')
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        AssistantSession::STATUS_LEAD_SUBMITTED => 'Lead submitted',
                        AssistantSession::STATUS_WHATSAPP => 'WhatsApp',
                        default => 'Exploring',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        AssistantSession::STATUS_LEAD_SUBMITTED => 'success',
                        AssistantSession::STATUS_WHATSAPP => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('name')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('phone')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('journey')
                    ->label('Intent')
                    ->formatStateUsing(fn ($state, AssistantSession $record): string => $record->journeyLabel())
                    ->sortable(),
                TextColumn::make('last_step')
                    ->label('Last step')
                    ->toggleable(),
                TextColumn::make('property.title')
                    ->label('Property')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('event_count')
                    ->label('Events')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('page_url')
                    ->label('Page')
                    ->limit(40)
                    ->tooltip(fn (?string $state): ?string => $state)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_activity_at')
                    ->label('Last active')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        AssistantSession::STATUS_EXPLORING => 'Exploring',
                        AssistantSession::STATUS_LEAD_SUBMITTED => 'Lead submitted',
                        AssistantSession::STATUS_WHATSAPP => 'WhatsApp',
                    ]),
                SelectFilter::make('journey')
                    ->options([
                        'site_visit' => 'Book a site visit',
                        'financing' => 'Pricing & financing',
                        'faq' => 'Project information',
                        'title' => 'Title & process',
                        'general' => 'General',
                    ]),
                TernaryFilter::make('has_contact')
                    ->label('Has contact details')
                    ->queries(
                        true: fn ($query) => $query->where(fn ($q) => $q->whereNotNull('phone')->orWhereNotNull('email')->orWhereNotNull('name')),
                        false: fn ($query) => $query->whereNull('phone')->whereNull('email')->whereNull('name'),
                    ),
            ])
            ->recordActions([
                TableActions::view(),
            ])
            ->toolbarActions(TableActions::bulk());
    }
}
