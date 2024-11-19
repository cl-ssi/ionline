<?php

namespace App\Filament\Clusters\Inventories\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Inventories;
use App\Models\Inventories\Eqm\Vehicle;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Imports\Eqm\VehicleImporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Filament\Clusters\Inventories\Resources\VehicleResource\Widgets\VehicleOverview;
use App\Filament\Clusters\Inventories\Resources\VehicleResource\Pages;
use App\Filament\Clusters\Inventories\Resources\VehicleResource\RelationManagers;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Inventories::class;

    protected static ?string $navigationGroup = 'Recursos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('region_id')
                    ->relationship('region', 'name'),
                Forms\Components\Select::make('establishment_id')
                    ->relationship('establishment', 'name'),
                Forms\Components\TextInput::make('body_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ambulance_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ambulance_class')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('samu')
                    ->required(),
                Forms\Components\TextInput::make('function')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name'),
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('license_plate')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('engine_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mileage')
                    ->numeric(),
                Forms\Components\TextInput::make('ownership_status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('conservation_status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('acquisition_year')
                    ->required(),
                Forms\Components\TextInput::make('useful_life')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('residual_useful_life')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('critical')
                    ->required(),
                Forms\Components\Toggle::make('under_warranty')
                    ->required(),
                Forms\Components\TextInput::make('warranty_expiry_year')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('under_maintenance_plan')
                    ->required(),
                Forms\Components\TextInput::make('year_entered_maintenance_plan')
                    ->required(),
                Forms\Components\TextInput::make('internal_or_external_maintenance')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('provider_or_internal_maintenance')
                    ->maxLength(255),
                Forms\Components\TextInput::make('maintenance_agreement_id_or_reference')
                    ->maxLength(255),
                Forms\Components\TextInput::make('annual_maintenance_cost')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('annual_maintenance_frequency')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('region.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('establishment.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('body_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ambulance_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ambulance_class')
                    ->searchable(),
                Tables\Columns\IconColumn::make('samu')
                    ->boolean(),
                Tables\Columns\TextColumn::make('function')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('engine_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mileage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ownership_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('conservation_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('acquisition_year'),
                Tables\Columns\TextColumn::make('useful_life')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('residual_useful_life')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('critical')
                    ->boolean(),
                Tables\Columns\IconColumn::make('under_warranty')
                    ->boolean(),
                Tables\Columns\TextColumn::make('warranty_expiry_year')
                    ->searchable(),
                Tables\Columns\IconColumn::make('under_maintenance_plan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('year_entered_maintenance_plan'),
                Tables\Columns\TextColumn::make('internal_or_external_maintenance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider_or_internal_maintenance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('maintenance_agreement_id_or_reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('annual_maintenance_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('annual_maintenance_frequency')
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
            ->headerActions([
                ImportAction::make('VehicleImporter')
                    ->label('Importar Vehículo')
                    ->importer(VehicleImporter::class)
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return 'Vehículo';
    }

    public static function getPluralLabel(): string
    {
        return 'Vehículos';
    }

    public static function getWidgets(): array
    {
        return [
            VehicleOverview::class,
        ];
    }
}
