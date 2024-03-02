<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SportNewsResource\Pages;
use App\Models\SportNews;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SportNewsResource extends Resource
{
    protected static ?string $model = SportNews::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Sport News';

    protected static ?string $navigationGroup = 'Application';

    protected static ?string $modelLabel = 'Sport News';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('news'),
                Forms\Components\TextInput::make('image_link'),
                Forms\Components\TextInput::make('short')
                    ->required()
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('content')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\ImageColumn::make('image_link'),

                Tables\Columns\TextColumn::make('title')
                    ->label('News Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('short')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->label('Post Date')
                    ->sortable(),
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
            'index' => Pages\ListSportNews::route('/'),
            'create' => Pages\CreateSportNews::route('/create'),
            'edit' => Pages\EditSportNews::route('/{record}/edit'),
        ];
    }
}
