<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Models\Lead;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentLeadsTable extends TableWidget
{
    protected static ?int $sort = 7;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Recent leads';

    public function table(Table $table): Table
    {
        return $table
            ->query(Lead::query()->latest()->limit(10))
            ->columns([
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('phone')
                    ->placeholder('—'),
                TextColumn::make('source')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('buyer_type')
                    ->label('Buyer type')
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('property.title')
                    ->label('Property')
                    ->limit(30)
                    ->placeholder('General enquiry'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted' => 'info',
                        'converted' => 'success',
                        default => 'gray',
                    }),
            ])
            ->paginated(false)
            ->recordUrl(fn (Lead $record): string => LeadResource::getUrl('edit', ['record' => $record]));
    }
}
