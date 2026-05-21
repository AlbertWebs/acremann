<?php

namespace App\Filament\Resources\Faqs\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category')->required()->default('general'),
                TextInput::make('question')->required(),
                FormComponents::richEditor('answer')->required(),
                TextInput::make('sort_order')->required()->numeric()->default(0),
                Toggle::make('is_published')->required(),
                Toggle::make('show_in_assistant')
                    ->label('Show in Acremann Assistant')
                    ->helperText('When enabled, this FAQ appears in the website chat widget.'),
            ]);
    }
}
