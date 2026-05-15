<?php

namespace App\Filament\Resources\Leads\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('source')->required(),
                TextInput::make('name'),
                TextInput::make('email')->email(),
                TextInput::make('phone')->tel(),
                Select::make('property_id')->relationship('property', 'title'),
                TextInput::make('buyer_type'),
                TextInput::make('budget'),
                TextInput::make('location_preference'),
                TextInput::make('property_interest'),
                FormComponents::richEditor('message'),
                Textarea::make('metadata')->rows(3)->columnSpanFull(),
                Toggle::make('consent_callback')->required(),
                Toggle::make('consent_whatsapp')->required(),
                Toggle::make('consent_email')->required(),
                Toggle::make('consent_marketing')->required(),
                TextInput::make('status')->required()->default('new'),
            ]);
    }
}
