<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                TextInput::make('icon'),
                Textarea::make('summary')->rows(3)->columnSpanFull(),
                FormComponents::richEditor('body'),
                TextInput::make('sort_order')->required()->numeric()->default(0),
                Toggle::make('is_published')->required(),
            ]);
    }
}
