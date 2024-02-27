<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OpenAdResource\Pages;
use App\Filament\Resources\OpenAdResource\RelationManagers;
use App\Models\OpenAd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OpenAdResource extends Resource
{
    protected static ?string $model = OpenAd::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('openad')
                    ->required(),
                Forms\Components\TextInput::make('link')
                    ->required()
                    ->label('Ads Link')
                    ->maxLength(255),
                Forms\Components\TextInput::make('display_second')
                    ->required()
                    ->label('Display time second')
                    ->default(5)
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_second')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListOpenAds::route('/'),
            'create' => Pages\CreateOpenAd::route('/create'),
            'edit' => Pages\EditOpenAd::route('/{record}/edit'),
        ];
    }
}
