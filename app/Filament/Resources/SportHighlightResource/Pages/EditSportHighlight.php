<?php

namespace App\Filament\Resources\SportHighlightResource\Pages;

use App\Filament\Resources\SportHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSportHighlight extends EditRecord
{
    protected static string $resource = SportHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
