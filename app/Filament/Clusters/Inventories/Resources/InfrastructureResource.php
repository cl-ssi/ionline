<?php

namespace App\Filament\Clusters\Inventories\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Inventories;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Inventories\Eqm\Infrastructure;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Imports\Eqm\InfrastructureImporter;

use App\Filament\Clusters\Inventories\Resources\InfrastructureResource\Widgets\InfrastructureOverview;
use App\Filament\Clusters\Inventories\Resources\InfrastructureResource\Pages;
use App\Filament\Clusters\Inventories\Resources\InfrastructureResource\RelationManagers;

class InfrastructureResource extends Resource
{
    protected static ?string $model = Infrastructure::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Inventories::class;

    protected static ?string $navigationGroup = 'Recursos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('place_id')
                    ->relationship('place', 'name'),
                Forms\Components\Select::make('location_id')
                    ->relationship('location', 'name'),
                Forms\Components\TextInput::make('infrastructure_element_or_specialty')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('intervention_type_description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('condition')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('norm_accreditation_or_not_applicable')
                    ->required()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('place.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('infrastructure_element_or_specialty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('condition')
                    ->searchable(),
                Tables\Columns\TextColumn::make('norm_accreditation_or_not_applicable')
                    ->searchable(),
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
                ImportAction::make('InfrastructureImporter')
                    ->label('Importar Infraestructura')
                    ->importer(InfrastructureImporter::class)
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
            'index' => Pages\ListInfrastructures::route('/'),
            'create' => Pages\CreateInfrastructure::route('/create'),
            'edit' => Pages\EditInfrastructure::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return 'Infraestructura';
    }

    public static function getPluralLabel(): string
    {
        return 'Infraestructuras';
    }

    public static function getWidgets(): array
    {
        return [
            InfrastructureOverview::class,
        ];
    }
}
