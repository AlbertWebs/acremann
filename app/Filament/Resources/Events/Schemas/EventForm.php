<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Event details')
                    ->icon(Heroicon::OutlinedCalendarDays)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Public URL: /events/{slug}'),
                        Textarea::make('excerpt')
                            ->label('Summary')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Shown on the events listing page.')
                            ->columnSpanFull(),
                        FormComponents::richEditor('description')
                            ->label('Description')
                            ->columnSpanFull(),
                        TextInput::make('location')
                            ->maxLength(255)
                            ->placeholder('e.g. Nachu, Kiambu'),
                        DateTimePicker::make('event_date')
                            ->label('Event date')
                            ->helperText('When the event took place (used for sorting and display).'),
                    ])
                    ->columns(2),
                Section::make('Photo gallery')
                    ->description('Upload a cover image for listings and multiple photos for the event gallery page.')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->extraAttributes(['class' => 'acremann-event-media-section'])
                    ->schema([
                        FileUpload::make('cover_image')
                            ->label('Cover image')
                            ->image()
                            ->directory('events/covers')
                            ->disk('public')
                            ->maxSize(5120)
                            ->imagePreviewHeight('20rem')
                            ->openable()
                            ->downloadable()
                            ->helperText('Optional hero image for cards and the top of the event page.')
                            ->columnSpanFull(),
                        FileUpload::make('gallery_images')
                            ->label('Gallery photos')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->directory('events/gallery')
                            ->disk('public')
                            ->maxFiles(48)
                            ->maxSize(5120)
                            ->imagePreviewHeight('14rem')
                            ->itemPanelAspectRatio('4/3')
                            ->panelLayout('grid')
                            ->openable()
                            ->downloadable()
                            ->helperText('Drag and drop multiple images. Reorder to control the gallery on the public page.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Publishing')
                    ->icon(Heroicon::OutlinedEye)
                    ->schema([
                        DateTimePicker::make('published_at')
                            ->label('Publish date')
                            ->default(now()),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Higher numbers appear first when event dates match.'),
                    ])
                    ->columns(3),
                Section::make('SEO')
                    ->icon(Heroicon::OutlinedMagnifyingGlass)
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('SEO title')
                            ->maxLength(255),
                        Textarea::make('meta_description')
                            ->label('SEO description')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
