<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\PlaceResource\Pages;
use App\Filament\Clusters\Parameters\Resources\PlaceResource\RelationManagers;
use App\Models\Parameters\Location;
use App\Models\Parameters\Place;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Lugar';
    protected static ?string $pluralModelLabel = 'Lugares';

    protected static ?string $cluster = Parameters::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('location_id')
                    ->label('Edificio')
                    ->relationship('location', 'name', fn(
                        Builder $query
                    ) => $query->orderBy('id', 'asc'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set('establishment_id', Location::find($get('location_id'))->establishment_id);
                    }),
                Forms\Components\TextInput::make('architectural_design_code')
                    ->label('Código Diseño Arquitectura')
                    ->default(null),
                Forms\Components\TextInput::make('establishment_id')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->label('Ubicación')
                    ->wrap()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('architectural_design_code')
                    ->label(new HtmlString('Código <br> Interno <br> Arquitectura'))
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('establishment.name')
                    ->label('Establecimiento')
                    ->wrap()
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('establishment_id', auth()->user()->establishment_id);
            })
            ->defaultSort('name', 'asc')
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
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }
}
