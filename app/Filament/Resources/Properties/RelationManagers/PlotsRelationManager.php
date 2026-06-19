<?php

namespace App\Filament\Resources\Properties\RelationManagers;

use App\Support\Money;
use App\Support\PropertyFormOptions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlotsRelationManager extends RelationManager
{
    protected static string $relationship = 'plots';

    protected static ?string $title = 'Plot list';

    protected static string|\BackedEnum|null $icon = Heroicon::OutlinedQueueList;

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('plot_number')
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50, 100])
            ->columns([
                TextColumn::make('plot_number')
                    ->label('Plot')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('size')
                    ->placeholder('—'),
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn (?string $state): string => filled($state)
                        ? Money::formatKesPrefixed($state)
                        : '—'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'reserved' => 'warning',
                        'sold' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->headerActions([
                CreateAction::make(),
                Action::make('deleteAllPlots')
                    ->label('Delete all plots')
                    ->icon(Heroicon::OutlinedTrash)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete all plots?')
                    ->modalDescription('This permanently removes every plot for this property. The public inventory will be empty until you generate or add plots again.')
                    ->modalSubmitActionLabel('Delete all')
                    ->visible(fn (): bool => $this->getOwnerRecord()->plots()->exists())
                    ->action(function (): void {
                        $property = $this->getOwnerRecord();
                        $count = $property->plots()->count();

                        $property->plots()->delete();

                        Notification::make()
                            ->title('All plots deleted')
                            ->body($count > 0
                                ? "Removed {$count} plots from this property."
                                : 'No plots to remove.')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('plot_number')
                    ->label('Plot #')
                    ->required()
                    ->maxLength(50),
                Select::make('status')
                    ->options(PropertyFormOptions::plotStatuses())
                    ->required()
                    ->native(false),
                TextInput::make('size')
                    ->label('Size')
                    ->maxLength(120),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('KES'),
            ]);
    }
}
