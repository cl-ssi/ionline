<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers;

use App\Models\ClCommune;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CdpsRelationManager extends RelationManager
{
    protected static string $relationship = 'cdps';

    protected static ?string $title = 'CDPs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Repeater::make('distribution')
                    ->schema([
                        Forms\Components\Select::make('commune_name')
                            ->options(ClCommune::pluck('name', 'name')->toArray())
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->reorderable(false)
                    ->columns(2)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date('Y-m-d'),
                Tables\Columns\TextColumn::make('distributionCommunes')
                    ->label('Distribución Comunas')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('distributionAmounts')
                    ->label('Montos')
                    ->bulleted(),
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
