<?php

namespace App\Filament\Resources\SiteVisitBookings\Schemas;

use App\Enums\SiteVisitBookingStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SiteVisitBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Client')
                    ->icon(Heroicon::OutlinedUser)
                    ->schema([
                        TextInput::make('name')->disabled(),
                        TextInput::make('email')->email()->disabled(),
                        TextInput::make('phone')->disabled(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                Section::make('Visit request')
                    ->icon(Heroicon::OutlinedMapPin)
                    ->schema([
                        Select::make('property_id')
                            ->relationship('property', 'title')
                            ->disabled(),
                        TextInput::make('property_interest')->disabled()->columnSpanFull(),
                        TextInput::make('buyer_type')->disabled(),
                        TextInput::make('budget')->disabled(),
                        Textarea::make('message')
                            ->label('Preferred date, time & notes')
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Process booking')
                    ->description('Update status when you confirm, complete, or cancel a visit. Clients with an email receive a notification when confirmed or cancelled.')
                    ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                    ->schema([
                        Select::make('status')
                            ->options(collect(SiteVisitBookingStatus::cases())->mapWithKeys(
                                fn (SiteVisitBookingStatus $status): array => [$status->value => $status->label()]
                            ))
                            ->required()
                            ->native(false),
                        DateTimePicker::make('processed_at')
                            ->label('Last processed')
                            ->disabled(),
                        Textarea::make('admin_notes')
                            ->label('Internal notes (included in client email when confirming or cancelling)')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Consents')
                    ->collapsed()
                    ->schema([
                        Toggle::make('consent_callback')->disabled(),
                        Toggle::make('consent_whatsapp')->disabled(),
                        Toggle::make('consent_email')->disabled(),
                        Toggle::make('consent_marketing')->disabled(),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }
}
