<?php

namespace App\Filament\Resources\FootballHighlightResource\Pages;

use App\Filament\Resources\FootballHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFootballHighlights extends ListRecords
{
    protected static string $resource = FootballHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
