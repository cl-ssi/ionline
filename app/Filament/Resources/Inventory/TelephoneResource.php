<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\TelephoneResource\Pages;
use App\Filament\Resources\Inventory\TelephoneResource\RelationManagers;
use App\Models\Establishment;
use App\Models\Parameters\Location;
use App\Models\Parameters\Place;
use App\Models\Resources\Telephone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TelephoneResource extends Resource
{
    protected static ?string $model = Telephone::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $modelLabel = 'Teléfono';

    protected static ?string $pluralModelLabel = 'Teléfonos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('minsal')
                    ->required()
                    ->numeric()
                    ->unique()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->numeric()
                    ->unique()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('mac')
                    ->maxLength(17)
                    ->default(null)
                    ->columnSpan(1),
                Forms\Components\Select::make('establishment_id')
                    ->label('Establecimiento')
                    ->options(
                        Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))
                            ->pluck('name', 'id')
                    )
                    ->live()
                    ->default(38)
                    ->columnSpan(1)
                    ->afterStateUpdated(function ($state, $set) {
                        $set('location_id', null);
                        $set('place_id', null);
                    }),
                Forms\Components\Select::make('location_id')
                    ->label('Edificio/Ubicación')
                    ->options(function (Get $get) {
                        if (! $get('establishment_id')) {
                            return [];
                        }

                        return Location::where('establishment_id', $get('establishment_id'))
                            ->orderBy('name')
                            ->pluck('name', 'id');
                    })
                    ->live()
                    ->afterStateUpdated(fn ($state, $set) => $set('place_id', null))
                    ->columnSpan(1),
                Forms\Components\Select::make('place_id')
                    ->relationship('place', 'name')
                    ->label('Lugar/Oficina/Sala/Box')
                    ->options(function (Get $get) {
                        if (! $get('location_id')) {
                            return [];
                        }

                        return Place::where('location_id', $get('location_id'))
                            ->orderBy('name')
                            ->pluck('name', 'id');
                    })
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('minsal')
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function (string $state) {
                        if (strlen($state) < 6) {
                            return $state;
                        }

                        return substr($state, 0, 2).' '.substr($state, 2);
                    }),
                Tables\Columns\TextColumn::make('number')
                    ->numeric()
                    ->label('Número')
                    ->sortable()
                    ->formatStateUsing(function (string $state) {
                        if (strlen($state) < 9) {
                            return $state;
                        }

                        return substr($state, 0, 2).' '.substr($state, 2, 3).' '.substr($state, 5);
                    }),
                Tables\Columns\TextColumn::make('users.full_name')
                    ->label('Usuarios')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->bulleted(),
                Tables\Columns\TextColumn::make('place.location.establishment.name')
                    ->searchable()
                    ->label('Establecimiento')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('place.name')
                //     ->searchable()
                //     ->label('Lugar')
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('place.location.name')
                //     ->searchable()
                //     ->label('Edificio')
                //     ->sortable(),
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
            ])
            ->defaultSort('number', 'asc');
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
            'index' => Pages\ListTelephones::route('/'),
            'create' => Pages\CreateTelephone::route('/create'),
            'edit' => Pages\EditTelephone::route('/{record}/edit'),
        ];
    }
}
