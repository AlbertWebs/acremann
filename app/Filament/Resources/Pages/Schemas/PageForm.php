<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')->required(),
                TextInput::make('title')->required(),
                TextInput::make('subtitle'),
                FormComponents::richEditor('content'),
                Textarea::make('blocks')->rows(4)->columnSpanFull()->helperText('JSON blocks if used'),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')->rows(2)->columnSpanFull(),
            ]);
    }
}
