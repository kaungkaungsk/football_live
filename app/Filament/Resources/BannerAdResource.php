<?php

namespace App\Filament\Resources;

use App\Enums\BannerAdLocationEnum;
use App\Filament\Resources\BannerAdResource\Pages;
use App\Models\BannerAd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerAdResource extends Resource
{
    protected static ?string $model = BannerAd::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Banner Ads';

    protected static ?string $navigationGroup = 'Advertisement';

    protected static ?string $modelLabel = 'Banner Ads';

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
                    ->directory('banner'),
                Forms\Components\TextInput::make('media_link')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('click_url')
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('height')
                    ->required()
                    ->numeric()
                    ->default(60),
                Forms\Components\TextInput::make('width')
                    ->numeric(),
                Forms\Components\Select::make('location')
                    ->label('Banner Location')
                    ->options([
                        'home' => 'Home Page',
                        'highlight' => 'Highlight Page',
                        'news' => 'News Page',
                        'movies' => 'Movies Page',
                        'channels' => 'Channels Page',
                        'player' => 'Player Page',
                        'server' => 'Server Page',
                    ])
                    ->default(0)
                    ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('media_path'),
                Tables\Columns\ImageColumn::make('media_link'),
                Tables\Columns\TextColumn::make('location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('click_count'),
                Tables\Columns\TextColumn::make('height')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('width')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('click_url')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBannerAds::route('/'),
            'create' => Pages\CreateBannerAd::route('/create'),
            'edit' => Pages\EditBannerAd::route('/{record}/edit'),
        ];
    }
}
