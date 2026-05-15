<?php

namespace App\Filament\Support;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

class TableActions
{
    public static function view(): ViewAction
    {
        return ViewAction::make()->color('info'); /* #4A6B8A */
    }

    public static function edit(): EditAction
    {
        return EditAction::make()->color('primary'); /* #2D4A3E */
    }

    public static function delete(): DeleteAction
    {
        return DeleteAction::make()->color('danger'); /* #DC2626 */
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
