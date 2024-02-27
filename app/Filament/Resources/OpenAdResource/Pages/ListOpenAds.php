<?php

namespace App\Filament\Resources\OpenAdResource\Pages;

use App\Filament\Resources\OpenAdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOpenAds extends ListRecords
{
    protected static string $resource = OpenAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
