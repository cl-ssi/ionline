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
            Forms\Components\Textarea::make('description')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Select::make('substance_id')
                ->relationship('substance', 'name')
                ->required(),
            Forms\Components\TextInput::make('nue')
                ->maxLength(255)
                ->default(null),
            Forms\Components\TextInput::make('sample_number')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('document_weight')
                ->numeric()
                ->default(null),
            Forms\Components\TextInput::make('gross_weight')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('net_weight')
                ->numeric()
                ->default(null),
            Forms\Components\TextInput::make('estimated_net_weight')
                ->numeric()
                ->default(null),
            Forms\Components\TextInput::make('sample')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('countersample')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('destruct')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('equivalent')
                ->maxLength(255)
                ->default(null),
            Forms\Components\Select::make('reception_id')
                ->relationship('reception', 'id')
                ->required(),
            Forms\Components\TextInput::make('result_number')
                ->numeric()
                ->default(null),
            Forms\Components\DatePicker::make('result_date'),
            Forms\Components\Select::make('result_substance_id')
                ->relationship('resultSubstance', 'name')
                ->default(null),
            Forms\Components\Toggle::make('dispose_precursor'),
            Forms\Components\TextInput::make('countersample_number')
                ->required()
                ->numeric(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('substance.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nue')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sample_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gross_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('net_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_net_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sample')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('countersample')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('destruct')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equivalent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reception.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('result_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('result_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('resultSubstance.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('dispose_precursor')
                    ->boolean(),
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
                Tables\Columns\TextColumn::make('countersample_number')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
