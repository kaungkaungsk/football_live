<?php

namespace App\Filament\Resources\SportHighlightResource\Pages;

use App\Filament\Resources\SportHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSportHighlights extends ListRecords
{
    protected static string $resource = SportHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
