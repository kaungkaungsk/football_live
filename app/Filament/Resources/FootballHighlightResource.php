<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FootballHighlightResource\Pages;
use App\Filament\Resources\FootballHighlightResource\RelationManagers;
use App\Models\FootballHighlight;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FootballHighlightResource extends Resource
{
    protected static ?string $model = FootballHighlight::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Football Hightlight';

    protected static ?string $navigationGroup = 'Application';

    protected static ?string $modelLabel = 'Football Hightlight';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('thumbnail')->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->autofocus(),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Select::make('link_type')
                    ->options([
                        'Youtube' => 'Youtube',
                        'M3U8' => 'M3U8',
                    ])
                    ->default(0)
                    ->required(),
                // Forms\Components\TextInput::make('views')
                //     ->numeric()
                //     ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('views')
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
            'index' => Pages\ListFootballHighlights::route('/'),
            'create' => Pages\CreateFootballHighlight::route('/create'),
            'edit' => Pages\EditFootballHighlight::route('/{record}/edit'),
        ];
    }
}
