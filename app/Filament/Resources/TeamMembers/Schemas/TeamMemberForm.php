<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('role')->required(),
                FormComponents::richEditor('bio'),
                FileUpload::make('photo_path')
                    ->label('Photo')
                    ->image()
                    ->directory('team')
                    ->disk('public')
                    ->maxSize(4096)
                    ->helperText('Portrait photo recommended (e.g. 600×750).'),
                Toggle::make('is_leadership')->required(),
                TextInput::make('sort_order')->required()->numeric()->default(0),
                Toggle::make('is_published')->required(),
            ]);
    }
}
