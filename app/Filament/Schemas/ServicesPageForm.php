<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ServicesPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Services page (/services)')
                    ->description('Intro text at the top of the public services listing. Individual service cards and detail pages are managed under Website → Services.')
                    ->icon(Heroicon::OutlinedBriefcase)
                    ->schema([
                        TextInput::make('services_page_eyebrow')
                            ->label('Eyebrow')
                            ->placeholder('What we offer')
                            ->maxLength(120),
                        TextInput::make('services_page_headline')
                            ->label('Headline')
                            ->placeholder('Professional property services')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('services_page_lead')
                            ->label('Introduction')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('services_page_section_title')
                            ->label('Grid section title')
                            ->placeholder('Explore our services')
                            ->maxLength(255),
                        Textarea::make('services_page_section_lead')
                            ->label('Grid section description')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
