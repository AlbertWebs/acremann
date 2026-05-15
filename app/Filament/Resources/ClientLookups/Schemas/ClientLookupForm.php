<?php

namespace App\Filament\Resources\ClientLookups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientLookupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference_number')
                    ->required(),
                TextInput::make('lookup_type')
                    ->required(),
                TextInput::make('client_name'),
                TextInput::make('client_phone')
                    ->tel(),
                TextInput::make('client_email')
                    ->email(),
                TextInput::make('status_message')
                    ->required(),
                TextInput::make('statement_path'),
            ]);
    }
}
