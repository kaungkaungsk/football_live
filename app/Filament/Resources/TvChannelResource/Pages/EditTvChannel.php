<?php

namespace App\Filament\Resources\TvChannelResource\Pages;

use App\Filament\Resources\TvChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTvChannel extends EditRecord
{
    protected static string $resource = TvChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
