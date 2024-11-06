<?php

namespace App\Filament\Clusters\Inventories\Resources;

use App\Filament\Clusters\Inventories;
use App\Filament\Clusters\Inventories\Resources\EquipmentResource\Pages;
use App\Filament\Clusters\Inventories\Resources\EquipmentResource\RelationManagers;
use App\Models\Inventories\Eqm\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Actions\ImportAction;
use App\Filament\Imports\Eqm\IndustrialEquipmentImporter;
use App\Filament\Imports\Eqm\MedicalEquipmentImporter;
// use App\Filament\Clusters\Inventories\Resources\Eqm\EquipmentResource\Pages;
// use App\Filament\Clusters\Inventories\Resources\Eqm\EquipmentResource\RelationManagers;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Inventories::class;

    protected static ?string $navigationGroup = 'Recursos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\Select::make('place_id')
                    ->relationship('place', 'name'),
                Forms\Components\Select::make('location_id')
                    ->relationship('location', 'name'),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name'),
                Forms\Components\Select::make('subcategory_id')
                    ->relationship('subcategory', 'name'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name'),
                Forms\Components\TextInput::make('model')
                    ->maxLength(255),
                Forms\Components\TextInput::make('serial_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('inventory_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('acquisition_year')
                    ->numeric(),
                Forms\Components\TextInput::make('useful_life')
                    ->numeric(),
                Forms\Components\TextInput::make('residual_useful_life')
                    ->numeric(),
                Forms\Components\TextInput::make('property')
                    ->maxLength(255),
                Forms\Components\TextInput::make('condition')
                    ->maxLength(255),
                Forms\Components\TextInput::make('importance')
                    ->maxLength(255),
                Forms\Components\TextInput::make('compilance')
                    ->maxLength(255),
                Forms\Components\TextInput::make('assurance')
                    ->maxLength(255),
                Forms\Components\TextInput::make('warranty_expiry_year')
                    ->maxLength(255),
                Forms\Components\TextInput::make('under_maintenance_plan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('year_entered_maintenance_plan')
                    ->numeric(),
                Forms\Components\TextInput::make('type_of_maintenance')
                    ->maxLength(255),
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'name'),
                Forms\Components\TextInput::make('maintenance_reference')
                    ->maxLength(255),
                Forms\Components\TextInput::make('annual_cost')
                    ->numeric(),
                Forms\Components\TextInput::make('annual_maintenance_frequency')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('place.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subcategory.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('inventory_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('acquisition_year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('useful_life')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('residual_useful_life')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('property')
                    ->searchable(),
                Tables\Columns\TextColumn::make('condition')
                    ->searchable(),
                Tables\Columns\TextColumn::make('importance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('compilance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('assurance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('warranty_expiry_year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('under_maintenance_plan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year_entered_maintenance_plan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type_of_maintenance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maintenance_reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('annual_cost')
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
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'Médico' => 'Médico',
                        'Industrial' => 'Industrial',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ImportAction::make('IndustrialEquipmentImporter')
                    ->label('Importar equipamiento industrial')
                    ->importer(IndustrialEquipmentImporter::class),
                ImportAction::make('MedicalEquipmentImporter')
                    ->label('Importar equipamiento médico')
                    ->importer(MedicalEquipmentImporter::class),
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return 'Equipamiento';
    }

    public static function getPluralLabel(): string
    {
        return 'Equipamientos';
    }
}
