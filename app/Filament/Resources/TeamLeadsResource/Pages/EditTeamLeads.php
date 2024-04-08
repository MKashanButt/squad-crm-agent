<?php

namespace App\Filament\Resources\TeamLeadsResource\Pages;

use App\Filament\Resources\TeamLeadsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeamLeads extends EditRecord
{
    protected static string $resource = TeamLeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
