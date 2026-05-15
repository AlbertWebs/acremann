<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FormComponents::richEditor('quote')->required(),
                TextInput::make('client_name')->required(),
                TextInput::make('client_detail'),
                Select::make('property_id')->relationship('property', 'title'),
                Toggle::make('is_featured')->required(),
                TextInput::make('sort_order')->required()->numeric()->default(0),
                Toggle::make('is_published')->required(),
            ]);
    }
}
