<?php

namespace App\Filament\Resources\SportNewsResource\Pages;

use App\Filament\Resources\SportNewsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSportNews extends ListRecords
{
    protected static string $resource = SportNewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
