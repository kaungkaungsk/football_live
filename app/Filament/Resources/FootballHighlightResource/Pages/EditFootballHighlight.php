<?php

namespace App\Filament\Resources\FootballHighlightResource\Pages;

use App\Filament\Resources\FootballHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFootballHighlight extends EditRecord
{
    protected static string $resource = FootballHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
