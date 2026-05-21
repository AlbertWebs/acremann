<?php

namespace App\Filament\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InvestPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero & headline')
                    ->description('Eyebrow, title, and intro line at the top of /invest.')
                    ->icon(Heroicon::OutlinedPresentationChartLine)
                    ->schema([
                        TextInput::make('subtitle')
                            ->label('Eyebrow')
                            ->placeholder('Future-focused land investment')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('title')
                            ->label('Page title')
                            ->required()
                            ->placeholder('Why Invest With Acremann')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Insight block')
                    ->description('Highlighted quote section below “How we work”.')
                    ->icon(Heroicon::OutlinedLightBulb)
                    ->schema([
                        FormComponents::richEditor('content')
                            ->label('Insight copy')
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
