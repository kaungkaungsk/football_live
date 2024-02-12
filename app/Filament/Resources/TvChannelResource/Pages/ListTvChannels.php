<?php

namespace App\Filament\Resources\TvChannelResource\Pages;

use App\Filament\Resources\TvChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTvChannels extends ListRecords
{
    protected static string $resource = TvChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
