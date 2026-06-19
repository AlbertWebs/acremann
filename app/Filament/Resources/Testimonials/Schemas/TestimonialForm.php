<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Client photo')
                    ->description('Shown in the homepage “What our clients say” carousel (client holding title deed, keys, etc.). Portrait or 4:5 photos work best.')
                    ->schema([
                        FileUpload::make('photo_path')
                            ->label('Photo')
                            ->image()
                            ->directory('testimonials')
                            ->disk('public')
                            ->maxSize(10240)
                            ->imagePreviewHeight('12rem')
                            ->helperText('Portrait photo, at least 1200 px wide for a sharp carousel (JPG, PNG, or WebP).')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Testimonial')
                    ->schema([
                        FormComponents::richEditor('quote')->required()->columnSpanFull(),
                        TextInput::make('client_name')->required(),
                        TextInput::make('client_detail')
                            ->placeholder('e.g. Nachu plot owner · Diaspora buyer')
                            ->helperText('Location, project name, or buyer type shown under the name.'),
                        Select::make('property_id')->relationship('property', 'title'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Visibility')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Featured on homepage')
                            ->helperText('Only featured, published testimonials appear on the home page carousel.')
                            ->required(),
                        TextInput::make('sort_order')->required()->numeric()->default(0),
                        Toggle::make('is_published')->required(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
