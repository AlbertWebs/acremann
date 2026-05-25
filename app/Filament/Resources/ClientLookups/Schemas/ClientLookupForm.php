<?php

namespace App\Filament\Resources\ClientLookups\Schemas;

use App\Enums\ClientLookupType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ClientLookupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Reference')
                    ->description('Clients use this reference on /client-portal. Use a unique code such as ACR-TITLE-001.')
                    ->icon(Heroicon::OutlinedIdentification)
                    ->schema([
                        TextInput::make('reference_number')
                            ->label('Reference number')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->helperText('Stored in uppercase. Letters, numbers, and hyphens only.')
                            ->regex('/^[A-Za-z0-9\-]+$/')
                            ->columnSpanFull(),
                        Select::make('lookup_type')
                            ->label('Portal tab')
                            ->options(collect(ClientLookupType::cases())->mapWithKeys(
                                fn (ClientLookupType $type): array => [$type->value => $type->label()]
                            ))
                            ->required()
                            ->native(false),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Client verification (recommended)')
                    ->description('When phone or email is set, the client must enter matching details on the portal. Leave both empty for reference-only lookup (less secure).')
                    ->icon(Heroicon::OutlinedShieldCheck)
                    ->schema([
                        TextInput::make('client_name')
                            ->label('Client name (internal)')
                            ->maxLength(255)
                            ->helperText('Not shown on the public portal — for your records only.'),
                        TextInput::make('client_phone')
                            ->label('Registered phone')
                            ->tel()
                            ->maxLength(30)
                            ->helperText('Digits only are stored. Client must enter a matching number.'),
                        TextInput::make('client_email')
                            ->email()
                            ->maxLength(255)
                            ->helperText('Client must enter this email when checking status.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Portal response')
                    ->description('Message shown after a successful lookup. Payment records can include a PDF statement.')
                    ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                    ->schema([
                        Textarea::make('status_message')
                            ->label('Status message')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        FileUpload::make('statement_path')
                            ->label('Payment statement (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('client-portal/statements')
                            ->disk('public')
                            ->maxSize(5120)
                            ->helperText('Optional. Only used for payment lookups — client can download after verification.')
                            ->visible(fn ($get): bool => $get('lookup_type') === ClientLookupType::Payment->value)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
