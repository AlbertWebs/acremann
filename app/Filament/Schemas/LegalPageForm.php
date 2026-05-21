<?php

namespace App\Filament\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class LegalPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page content')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        FormComponents::richEditor('content')
                            ->label('Body')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('SEO')
                    ->icon(Heroicon::OutlinedMagnifyingGlass)
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('meta_description')
                            ->label('Meta description')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
