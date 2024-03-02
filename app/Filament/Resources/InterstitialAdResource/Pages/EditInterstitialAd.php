<?php

namespace App\Filament\Resources\InterstitialAdResource\Pages;

use App\Filament\Resources\InterstitialAdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInterstitialAd extends EditRecord
{
    protected static string $resource = InterstitialAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
