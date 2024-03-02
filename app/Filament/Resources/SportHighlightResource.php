<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SportHighlightResource\Pages;
use App\Models\SportHighlight;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SportHighlightResource extends Resource
{
    protected static ?string $model = SportHighlight::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Sport Hightlight';

    protected static ?string $navigationGroup = 'Application';

    protected static ?string $modelLabel = 'Sport Hightlight';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\DatePicker::make('match_date')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('team1_name')
                        ->label('Home Team'),

                    Forms\Components\TextInput::make('team2_name')
                        ->label('Away Team'),

                    Forms\Components\TextInput::make('team1_logo')
                        ->label('Home Team Logo Link'),

                    Forms\Components\TextInput::make('team2_logo')
                        ->label('Away Team Logo Link'),

                    Forms\Components\TextInput::make('vs')
                        ->label('VS Result'),

                    Forms\Components\TextInput::make('link')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('referer')
                        ->columnSpanFull(),
                    Forms\Components\Select::make('link_type')
                        ->options([
                            'Default' => 'Default',
                            'Youtube' => 'Youtube',
                        ])
                        ->default(0),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('match_date')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('team1_logo')->label('Logo'),
                Tables\Columns\TextColumn::make('team1_name')
                    ->label('Home Team')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vs')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('team2_logo')->label('Logo'),
                Tables\Columns\TextColumn::make('team2_name')
                    ->label('Away Team')
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('match_date', 'desc')
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
            'index' => Pages\ListSportHighlights::route('/'),
            'create' => Pages\CreateSportHighlight::route('/create'),
            'edit' => Pages\EditSportHighlight::route('/{record}/edit'),
        ];
    }
}
