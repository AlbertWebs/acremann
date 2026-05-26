<?php

namespace App\Filament\Resources\Properties\Tables;

use App\Filament\Support\TableActions;
use App\Models\Property;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return static::baseTable($table)
            ->defaultSort('sort_order')
            ->columns(static::columns(includeFeaturedFlag: true, includeSortOrder: true));
    }

    public static function configureFeatured(Table $table): Table
    {
        return static::baseTable($table)
            ->defaultSort('sort_order')
            ->columns(static::columns(includeFeaturedFlag: false, includeSortOrder: true));
    }

    protected static function baseTable(Table $table): Table
    {
        return $table
            ->recordActions(static::recordActions())
            ->filters([])
            ->toolbarActions(TableActions::bulk());
    }

    /**
     * @return array<int, mixed>
     */
    protected static function columns(bool $includeFeaturedFlag, bool $includeSortOrder): array
    {
        $columns = [
            ImageColumn::make('thumbnail')
                ->label('Photo')
                ->disk('public')
                ->visibility('public')
                ->getStateUsing(fn (Property $record): ?string => $record->adminThumbnailPath())
                ->square()
                ->imageSize(56),
            TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->grow()
                ->wrap()
                ->description(fn (Property $record): string => collect([$record->location, $record->county])
                    ->filter()
                    ->implode(' · ')),
            TextColumn::make('price_display')
                ->label('Price')
                ->getStateUsing(fn (Property $record): string => $record->formattedPrice())
                ->sortable(query: function ($query, string $direction): void {
                    $query->orderBy('price_from', $direction);
                }),
            TextColumn::make('plot_availability')
                ->label('Plots')
                ->getStateUsing(fn (Property $record): string => $record->availabilityDisplayLabel())
                ->badge()
                ->color(fn (Property $record): string => $record->isSoldOut() ? 'danger' : 'success'),
            IconColumn::make('is_published')
                ->label('Live')
                ->boolean()
                ->alignCenter(),
        ];

        if ($includeSortOrder) {
            $columns[] = TextColumn::make('sort_order')
                ->label('Order')
                ->numeric()
                ->sortable()
                ->alignCenter()
                ->width('4rem');
        }

        if ($includeFeaturedFlag) {
            $columns[] = IconColumn::make('is_featured')
                ->label('Featured')
                ->boolean()
                ->alignCenter()
                ->toggleable();
        }

        $columns[] = TextColumn::make('updated_at')
            ->label('Updated')
            ->since()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);

        return $columns;
    }

    /**
     * @return array<int, mixed>
     */
    protected static function recordActions(): array
    {
        return [
            TableActions::edit(),
            TableActions::view(),
            TableActions::viewLive(
                url: fn (Property $record): string => route('properties.show', $record->slug),
                visible: fn (Property $record): bool => $record->is_published && filled($record->slug),
            ),
        ];
    }
}
