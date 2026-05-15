<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use App\Filament\Support\FormComponents;
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
                TextInput::make('photo_path'),
                Toggle::make('is_leadership')->required(),
                TextInput::make('sort_order')->required()->numeric()->default(0),
                Toggle::make('is_published')->required(),
            ]);
    }
}
