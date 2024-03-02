<?php

namespace App\Filament\Resources\InterstitialAdResource\Pages;

use App\Filament\Resources\InterstitialAdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInterstitialAds extends ListRecords
{
    protected static string $resource = InterstitialAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
