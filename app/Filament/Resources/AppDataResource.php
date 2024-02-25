<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppDataResource\Pages;
use App\Filament\Resources\AppDataResource\RelationManagers;
use App\Models\AppData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppDataResource extends Resource
{
    protected static ?string $model = AppData::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'App Setting';

    protected static ?string $navigationGroup = 'Management';

    protected static ?string $modelLabel = 'App Setting';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('interstitial_frequency')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('help_center_link')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('privacy_policy_link')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('interstitial_frequency')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('help_center_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('privacy_policy_link')
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
            'index' => Pages\ListAppData::route('/'),
            'create' => Pages\CreateAppData::route('/create'),
            'edit' => Pages\EditAppData::route('/{record}/edit'),
        ];
    }
}
