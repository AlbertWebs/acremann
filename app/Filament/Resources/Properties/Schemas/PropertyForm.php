<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                TextInput::make('slug')->required(),
                TextInput::make('status')->required()->default('available'),
                TextInput::make('project_status')->required()->default('selling'),
                TextInput::make('price_from')->numeric(),
                TextInput::make('price_label'),
                TextInput::make('plot_size'),
                TextInput::make('location')->required(),
                TextInput::make('county'),
                TextInput::make('category')->required()->default('residential'),
                TextInput::make('title_type')->required()->default('freehold'),
                TextInput::make('listing_type')->required()->default('sale'),
                FormComponents::richEditor('summary'),
                FormComponents::richEditor('description'),
                Textarea::make('amenities')->rows(4)->columnSpanFull()->helperText('One amenity per line'),
                Textarea::make('map_embed')->rows(3)->columnSpanFull(),
                Textarea::make('distance_notes')->rows(4)->columnSpanFull(),
                TextInput::make('tour_embed_url')->url(),
                TextInput::make('brochure_path'),
                FormComponents::richEditor('title_process'),
                FormComponents::richEditor('investor_angle'),
                Textarea::make('sustainability_markers')->rows(4)->columnSpanFull(),
                Toggle::make('is_featured')->required(),
                Toggle::make('is_published')->required(),
                TextInput::make('sort_order')->required()->numeric()->default(0),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')->rows(2)->columnSpanFull(),
            ]);
    }
}
