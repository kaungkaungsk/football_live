<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TvChannelResource\Pages;
use App\Filament\Resources\TvChannelResource\RelationManagers;
use App\Models\TvChannel;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TvChannelResource extends Resource
{
    protected static ?string $model = TvChannel::class;

    protected static ?string $navigationIcon = 'heroicon-o-tv';

    protected static ?string $navigationLabel = 'TV Channel';

    protected static ?string $navigationGroup = 'Application';

    protected static ?string $modelLabel = 'TV Channel';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image'),
                Forms\Components\TextInput::make('channel_name')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),
                Forms\Components\Select::make('category')
                    ->options([
                        'Myanmar Channels' => 'Myanmar Channels',
                        'Movies Channels' => 'Movies Channels',
                        'Sport Channels' => 'Sport Channels',
                        'Kids Channels' => 'Kids Channels',
                        'News Channels' => 'News Channels',
                    ])
                    ->default(0)
                    ->required(),
                Forms\Components\Textarea::make('link')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_m3u8')
                    ->required()
                    ->default(true),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('channel_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_m3u8')
                    ->boolean(),
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTvChannels::route('/'),
            'create' => Pages\CreateTvChannel::route('/create'),
            'edit' => Pages\EditTvChannel::route('/{record}/edit'),
        ];
    }
}
