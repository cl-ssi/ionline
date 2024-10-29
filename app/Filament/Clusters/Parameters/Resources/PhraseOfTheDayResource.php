<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\PhraseOfTheDayResource\Pages;
use App\Filament\Clusters\Parameters\Resources\PhraseOfTheDayResource\RelationManagers;
use App\Models\Parameters\PhraseOfTheDay;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PhraseOfTheDayResource extends Resource
{
    protected static ?string $model = PhraseOfTheDay::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Parameters::class;

    protected static ?string $modelLabel = 'Frase del Día';

    protected static ?string $navigationGroup = 'Sistema';

    protected static ?string $pluralModelLabel = 'Frases del Día';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('phrase')
                    ->required()
                    ->label('Frase')
                    ->autosize()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('id')
                        ->searchable()
                        ->badge()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('phrase')
                        ->label('Frase')
                        ->html()
                        ->getStateUsing(function ($record) {
                            return '<pre style="white-space: pre-wrap; word-wrap: break-word;">' . htmlspecialchars($record->phrase) . '</pre>';
                        })
                        ->searchable(),
                ])
            ])
            ->defaultSort('created_at', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])->contentGrid([
                'md' => 1,
                'xl' => 1,
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
            'index' => Pages\ListPhraseOfTheDays::route('/'),
            'create' => Pages\CreatePhraseOfTheDay::route('/create'),
            'edit' => Pages\EditPhraseOfTheDay::route('/{record}/edit'),
        ];
    }
}
