<?php

namespace App\Filament\Resources\SportNewsResource\Pages;

use App\Filament\Resources\SportNewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSportNews extends EditRecord
{
    protected static string $resource = SportNewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
