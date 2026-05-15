<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PropertyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('status'),
                TextEntry::make('project_status'),
                TextEntry::make('price_from')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('price_label')
                    ->placeholder('-'),
                TextEntry::make('plot_size')
                    ->placeholder('-'),
                TextEntry::make('location'),
                TextEntry::make('county')
                    ->placeholder('-'),
                TextEntry::make('category'),
                TextEntry::make('title_type'),
                TextEntry::make('listing_type'),
                TextEntry::make('summary')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('amenities')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('map_embed')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('distance_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('tour_embed_url')
                    ->placeholder('-'),
                TextEntry::make('brochure_path')
                    ->placeholder('-'),
                TextEntry::make('title_process')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('investor_angle')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('sustainability_markers')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_published')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->numeric(),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
