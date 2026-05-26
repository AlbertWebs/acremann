<?php

namespace App\Filament\Resources\TeamMembers\Pages;

use App\Filament\Resources\TeamMembers\TeamMemberResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeamMember extends EditRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if ($this->getRecord()->is_leadership) {
            $actions[] = Action::make('viewLive')
                ->label('View profile')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('leadership.show', $this->getRecord()))
                ->openUrlInNewTab();
        }

        $actions[] = DeleteAction::make();

        return $actions;
    }
}
