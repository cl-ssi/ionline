<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommitmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'commitments';

    protected static ?string $modelLabel = 'Compromiso';

    protected static ?string $title = 'Compromisos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->extraAttributes(['class' => 'whitespace-normal']),
                Tables\Columns\TextColumn::make('commitmentUser.shortName')
                    ->label('Usuario / Unidad Organizacional'),
                Tables\Columns\TextColumn::make('closing_date')
                    ->label('Fecha límite')
                    ->dateTime('d-m-Y'),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Prioridad')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'normal'    => 'success',
                        'urgente'   => 'danger',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('requirement.status')
                    ->label('Estado SGR')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cerrado'       => 'success',
                        'creado'        => 'gray',
                        'derivado'      => 'info',
                        'reabierto'     => 'primary',
                        'respondido'    => 'warning'
                    })
                    ->alignment('center'),
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
