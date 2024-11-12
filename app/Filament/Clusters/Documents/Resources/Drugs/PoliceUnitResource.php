<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Drugs\PoliceUnitResource\Pages;
use App\Filament\Clusters\Documents\Resources\Drugs\PoliceUnitResource\RelationManagers;
use App\Models\Drugs\PoliceUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PoliceUnitResource extends Resource
{
    protected static ?string $model = PoliceUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Drogas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Código')
                    ->maxLength(8)
                    ->required()
                    ->default(null),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->label('Estado'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Estado')
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
            ->defaultSort('name', 'asc')
            ->filters([
                TernaryFilter::make('status')
                    ->nullable()
                    ->label('Estado')
                    ->attribute('status')
                    ->trueLabel('Activo')
                    ->falseLabel('Inactivo')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListPoliceUnits::route('/'),
            'create' => Pages\CreatePoliceUnit::route('/create'),
            'edit' => Pages\EditPoliceUnit::route('/{record}/edit'),
        ];
    }
}
