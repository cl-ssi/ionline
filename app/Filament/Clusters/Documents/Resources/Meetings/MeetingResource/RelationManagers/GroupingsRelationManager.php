<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupingsRelationManager extends RelationManager
{
    protected static string $relationship = 'groupings';

    protected static ?string $title = 'Asociaciones de Funcionarios / Federaciones Regionales / Reunión Mesas y Comités de Trabajos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'asociaciones funcionarios' => 'Asociaciones de Funcionarios', 
                        'federaciones regionales'   => 'Federaciones Regionales',
                        'funcionario'               => 'Funcionario',
                        'mesas comites de trabajo'  => 'Reunión Mesas y Comités de Trabajos',
                    ])
                    ->default(null)
                    ->reactive() // Permite detectar cambios en tiempo real
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Si el valor es "funcionario", el campo "name" será null
                        if ($state === 'funcionario') {
                            $set('name', null);
                        }
                    })
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->maxLength(255)
                    ->disabled(fn (callable $get) => $get('type') === 'funcionario') // Desactivar si el tipo es "funcionario"
                    ->placeholder(fn (callable $get) => $get('type') === 'funcionario' ? 'Desactivado para funcionarios' : null), // Mensaje para indicar que está desactivado,
                Forms\Components\Select::make('user_id')
                    ->label('Funcionario')
                    ->relationship('user', 'full_name') // Relación con el modelo User
                    ->searchable()
                    ->visible(fn (callable $get) => $get('type') === 'funcionario'), // Solo visible si el tipo es "funcionario"
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->getStateUsing(fn ($record) => ucfirst($record->type)),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->getStateUsing(fn ($record) => ucfirst($record->name)),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Crear')
                    ->authorize(fn () => $this->getOwnerRecord()->status === 'saved'), // Solo habilitar si el estado es 'saved',
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->authorize(fn ($record) => $this->getOwnerRecord()->status === 'saved'), // Solo habilitar si el estado es 'saved',
                Tables\Actions\DeleteAction::make()
                    ->authorize(fn ($record) => $this->getOwnerRecord()->status === 'saved'), // Solo habilitar si el estado es 'saved',
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
