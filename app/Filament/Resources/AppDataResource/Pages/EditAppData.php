<?php

namespace App\Filament\Resources\AppDataResource\Pages;

use App\Filament\Resources\AppDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppData extends EditRecord
{
    protected static string $resource = AppDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
