<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\ReceptionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nue')
                    ->label('NUE')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('substance_id')
                    ->label('Sustancia')
                    ->relationship('substance', 'name', fn (Builder $query) => $query->where('presumed', true))
                    ->required()
                    ->columnSpan(2),
                Forms\Components\TextInput::make('sample_number')
                    ->label('Nª de Muestras')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('countersample_number')
                    ->label('N° Contramuestras')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('document_weight')
                    ->label('Peso oficio')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('gross_weight')
                    ->label('Peso Bruto')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('net_weight')
                    ->label('Peso Neto')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('sample')
                    ->label('Muestra')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('countersample')
                    ->label('Contramuestra')
                    ->required()
                    ->numeric(),
                // Forms\Components\TextInput::make('destruct')
                //     ->label('Destrucción')
                //     ->required()
                //     ->numeric(),
                Forms\Components\TextInput::make('equivalent')
                    ->label('Equivalente')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('estimated_net_weight')
                    ->label('Peso Neto Estimado')
                    ->numeric()
                    ->default(null),

                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->required()
                    ->columnSpanFull(),
                // Forms\Components\Select::make('reception_id')
                //     ->label('Recepción')
                //     ->relationship('reception', 'id')
                //     ->required(),
                Forms\Components\Fieldset::make('Resultado')
                    ->schema([
                        Forms\Components\TextInput::make('result_number')
                        ->label('N° Resultado')
                        ->numeric()
                        ->default(null),
                    Forms\Components\DatePicker::make('result_date')
                        ->label('Fecha de Resultado'),
                    Forms\Components\Select::make('result_substance_id')
                        ->label('Sustancia Resultado')
                        ->relationship('resultSubstance', 'name', fn (Builder $query) => $query->where('presumed', true))
                        ->default(null),
                    ])
                    ->columns(3),

                Forms\Components\Toggle::make('dispose_precursor')
                    ->label('Disponer Precursor')
                    ->columnSpan(3),

            ])
            ->columns(6);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('substance.name')
                    ->label('Sustancia')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nue')
                    ->label('NUE')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sample_number')
                    ->label('Nª Muestras')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('countersample_number')
                    ->label('Nª Contramuestras')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_weight')
                    ->label('Peso oficio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gross_weight')
                    ->label('Peso Bruto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('net_weight')
                    ->label('Peso Neto')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('estimated_net_weight')
                //     ->label('Peso Neto Estimado')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('sample')
                    ->label('Muestra')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('countersample')
                    ->label('Contramuestra')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('destruct')
                    ->label('Destrucción')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('equivalent')
                //     ->label('Equivalente')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('reception.id')
                //     ->label('Recepción')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('result_number')
                //     ->label('Número de Resultado')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('result_date')
                //     ->label('Fecha de Resultado')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('resultSubstance.name')
                //     ->label('Sustancia del Resultado')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('dispose_precursor')
                //     ->label('Disponer Precursor')
                //     ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Fecha de Eliminación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}