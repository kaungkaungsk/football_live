<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FootballMatchResource\Pages;
use App\Filament\Resources\FootballMatchResource\RelationManagers;
use App\Models\FootballMatch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FootballMatchResource extends Resource
{
    protected static ?string $model = FootballMatch::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Football Match';

    protected static ?string $navigationGroup = 'Application';

    protected static ?string $modelLabel = 'Football Match';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('team1_id')
                    ->relationship('team1', 'team_name')
                    ->required()
                    ->label('Home Team')
                    ->placeholder('Select Home Team'),
                Forms\Components\Select::make('team2_id')
                    ->relationship('team2', 'team_name')
                    ->required()
                    ->label('Away Team')
                    ->placeholder('Select Away Team'),
                Forms\Components\Select::make('tag_id')
                    ->relationship('tag', 'title')
                    ->required()
                    ->placeholder('Select Match Tag'),
                Forms\Components\DateTimePicker::make('match_date')
                    ->required(),
                Forms\Components\Textarea::make('links')
                    ->columnSpanFull()
                    ->placeholder('Please sperate with [ , ] for multiple links')
                    ->required(),
                Forms\Components\Select::make('link_type')
                    ->options([
                        'M3U8' => 'M3U8',
                        'RTMP' => 'RTMP',
                    ])
                    ->default(0)
                    ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('team1.team_name')
                    ->searchable()
                    ->label('Home'),
                Tables\Columns\TextColumn::make('team2.team_name')
                    ->searchable()
                    ->label('Away'),
                Tables\Columns\TextColumn::make('tag.title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('match_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('link_type')
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
            'index' => Pages\ListFootballMatches::route('/'),
            'create' => Pages\CreateFootballMatch::route('/create'),
            'edit' => Pages\EditFootballMatch::route('/{record}/edit'),
        ];
    }
}
