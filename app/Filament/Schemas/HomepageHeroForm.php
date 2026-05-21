<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class HomepageHeroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero copy')
                    ->description('Text and buttons shown in the large banner at the top of the homepage.')
                    ->schema([
                        TextInput::make('hero_eyebrow')
                            ->label('Eyebrow')
                            ->placeholder('Trusted real estate company Kenya')
                            ->maxLength(120)
                            ->columnSpanFull(),
                        TextInput::make('hero_headline')
                            ->label('Headline')
                            ->placeholder('Trusted guidance. Transparent process. Sustainable value.')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('hero_description')
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Call-to-action buttons')
                    ->schema([
                        TextInput::make('hero_cta_primary_label')
                            ->label('Primary button label')
                            ->placeholder('View properties')
                            ->maxLength(80),
                        TextInput::make('hero_cta_primary_url')
                            ->label('Primary button link')
                            ->placeholder('/properties')
                            ->helperText('Relative path (e.g. /properties) or full URL.')
                            ->maxLength(500),
                        TextInput::make('hero_cta_secondary_label')
                            ->label('Secondary button label')
                            ->placeholder('Book a site visit')
                            ->maxLength(80),
                        TextInput::make('hero_cta_secondary_url')
                            ->label('Secondary button link')
                            ->placeholder('/contact')
                            ->maxLength(500),
                        Toggle::make('hero_show_whatsapp_cta')
                            ->label('Show WhatsApp button')
                            ->default(true)
                            ->columnSpanFull(),
                        TextInput::make('hero_whatsapp_label')
                            ->label('WhatsApp button label')
                            ->placeholder('WhatsApp us')
                            ->maxLength(80)
                            ->visible(fn (Get $get): bool => (bool) $get('hero_show_whatsapp_cta')),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Hero images')
                    ->description('Upload images for the right side of the homepage hero. The first image is shown larger in the grid.')
                    ->schema([
                        Select::make('hero_media_mode')
                            ->label('Right column content')
                            ->options([
                                'featured_properties' => 'Featured property photos (grid)',
                                'gallery' => 'Custom hero images (uploaded)',
                                'none' => 'No image — text only (full width)',
                            ])
                            ->default('featured_properties')
                            ->required()
                            ->live()
                            ->columnSpanFull(),
                        FileUpload::make('hero_images')
                            ->label('Hero images')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->directory('hero')
                            ->disk('public')
                            ->maxFiles(6)
                            ->maxSize(5120)
                            ->imagePreviewHeight('10rem')
                            ->panelLayout('grid')
                            ->openable()
                            ->downloadable()
                            ->helperText('Landscape photos work best (1200×800 px or larger). Drag to reorder — the first 3 images appear on the homepage (1 large, 2 smaller). Extra uploads are kept but not shown on the homepage.')
                            ->visible(fn (Get $get): bool => static::usesCustomHeroImages($get))
                            ->live()
                            ->columnSpanFull(),
                        View::make('filament.homepage-hero.preview')
                            ->visible(fn (Get $get): bool => static::usesCustomHeroImages($get))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function usesCustomHeroImages(Get $get): bool
    {
        return in_array($get('hero_media_mode'), ['gallery', 'image'], true);
    }
}
