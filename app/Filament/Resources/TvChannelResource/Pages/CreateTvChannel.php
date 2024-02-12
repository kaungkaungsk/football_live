<?php

namespace App\Filament\Resources\TvChannelResource\Pages;

use App\Filament\Resources\TvChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTvChannel extends CreateRecord
{
    protected static string $resource = TvChannelResource::class;
}
