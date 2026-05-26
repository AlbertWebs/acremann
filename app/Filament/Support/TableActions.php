<?php

namespace App\Filament\Support;

use Closure;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;

class TableActions
{
    public static function view(): ViewAction
    {
        return ViewAction::make()
            ->label('View')
            ->icon(Heroicon::OutlinedEye)
            ->button()
            ->outlined()
            ->size(Size::Small)
            ->color('info');
    }

    public static function edit(): EditAction
    {
        return EditAction::make()
            ->label('Edit')
            ->icon(Heroicon::OutlinedPencilSquare)
            ->button()
            ->outlined()
            ->size(Size::Small)
            ->color('primary');
    }

    public static function delete(): DeleteAction
    {
        return DeleteAction::make()
            ->label('Delete')
            ->icon(Heroicon::OutlinedTrash)
            ->button()
            ->outlined()
            ->size(Size::Small)
            ->color('danger');
    }

    public static function viewLive(string|Closure $url, bool|Closure $visible = true): Action
    {
        return Action::make('viewLive')
            ->label('Live')
            ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
            ->button()
            ->outlined()
            ->size(Size::Small)
            ->color('gray')
            ->url($url, shouldOpenInNewTab: true)
            ->visible($visible);
    }

    /** @return array<int, BulkActionGroup> */
    public static function bulk(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make()->color('danger'),
            ]),
        ];
    }
}
