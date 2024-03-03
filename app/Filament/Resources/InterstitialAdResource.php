<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterstitialAdResource\Pages;
use App\Models\InterstitialAd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InterstitialAdResource extends Resource
{
    protected static ?string $model = InterstitialAd::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Interstitial Ads';

    protected static ?string $navigationGroup = 'Advertisement';

    protected static ?string $modelLabel = 'Interstitial Ads';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('media_path')
                    ->image()
                    ->directory('interstitial'),
                Forms\Components\TextInput::make('media_link')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('click_url')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('media_path'),
                Tables\Columns\ImageColumn::make('media_link'),

                Tables\Columns\TextColumn::make('click_count'),
                Tables\Columns\TextColumn::make('click_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInterstitialAds::route('/'),
            'create' => Pages\CreateInterstitialAd::route('/create'),
            'edit' => Pages\EditInterstitialAd::route('/{record}/edit'),
        ];
    }
}
