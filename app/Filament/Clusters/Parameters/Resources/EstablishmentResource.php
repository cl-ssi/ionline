<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\EstablishmentResource\Pages;
use App\Filament\Clusters\Parameters\Resources\EstablishmentResource\RelationManagers;
use App\Models\Establishment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstablishmentResource extends Resource
{
    protected static ?string $model = Establishment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Parameters::class;

    protected static ?string $modelLabel = 'establecimiento';

    protected static ?string $pluralModelLabel = 'establecimientos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alias')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\Select::make('establishment_type_id')
                    ->relationship('establishmentType', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('deis')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('new_deis')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('mother_code')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('new_mother_code')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('sirh_code')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('commune_id')
                    ->relationship('commune', 'name')
                    ->required(),
                Forms\Components\TextInput::make('dependency')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('health_service_id')
                    ->relationship('healthService', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('official_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('administrative_dependency')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('level_of_care')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('street_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('street_number')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('url')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('telephone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('emergency_service')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('latitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('longitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('level_of_complexity')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('provider_type_health_system')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('mail_director')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('father_organizational_unit_id')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('alias')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                // Tables\Columns\TextColumn::make('establishmentType.name')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('deis')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('new_deis')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('mother_code')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('new_mother_code')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sirh_code')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('commune.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('dependency')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('healthService.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('official_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('administrative_dependency')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('level_of_care')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('street_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('street_number')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('address')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('url')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('telephone')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('emergency_service')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('latitude')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('longitude')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('level_of_complexity')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('provider_type_health_system')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mail_director')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('father_organizational_unit_id')
                //     ->numeric()
                //     ->sortable(),
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
            'index' => Pages\ListEstablishments::route('/'),
            'create' => Pages\CreateEstablishment::route('/create'),
            'edit' => Pages\EditEstablishment::route('/{record}/edit'),
        ];
    }
}
