<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\MunicipalityResource\Pages;
use App\Filament\Clusters\Documents\Resources\Agreements\MunicipalityResource\RelationManagers;
use App\Models\Parameters\Municipality;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MunicipalityResource extends Resource
{
    protected static ?string $model = Municipality::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Convenios';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_municipality')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rut_municipality')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_municipality')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email_municipality_2')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('adress_municipality')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('appellative_representative')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('decree_representative')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_representative')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rut_representative')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('commune_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name_representative_surrogate')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('rut_representative_surrogate')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('decree_representative_surrogate')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('appellative_representative_surrogate')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_municipality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rut_municipality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_municipality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_municipality_2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adress_municipality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('appellative_representative')
                    ->searchable(),
                Tables\Columns\TextColumn::make('decree_representative')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_representative')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rut_representative')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commune_id')
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
                Tables\Columns\TextColumn::make('name_representative_surrogate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rut_representative_surrogate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('decree_representative_surrogate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('appellative_representative_surrogate')
                    ->searchable(),
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
            'index' => Pages\ListMunicipalities::route('/'),
            'create' => Pages\CreateMunicipality::route('/create'),
            'edit' => Pages\EditMunicipality::route('/{record}/edit'),
        ];
    }
}
