<?php

namespace App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class AvailablePlacesRelationManager extends RelationManager
{
    protected static string $relationship = 'availablePlaces';

    protected static ?string $modelLabel = 'Cupos por Estamento';

    protected static ?string $title = 'Cupos por Estamento';
    
    public function canCreate(): bool
    {
        return $this->isEditable();
    }

    public function canEdit(Model $record): bool
    {
        return $this->isEditable();
    }

    public function canDelete(Model $record): bool
    {
        return $this->isEditable();
    }

    private function isEditable(): bool
    {
        return in_array($this->getOwnerRecord()->status, ['saved']);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('estament_id')
                    ->label('Estamento')
                    ->relationship('estament', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('family_position')
                    ->label('Familia de Cargo')
                    ->options([
                        'profesional directivo'         => 'Profesional Directivo', 
                        'profesional gestion'           => 'Profesional de Gestión',
                        'profesional asistencial'       => 'Profesional Asistencial',
                        'tecnico de apoyo a la gestion' => 'Técnico de Apoyo a la Gestión',
                        'tecnico asistencial'           => 'Técnico Asistencial',
                        'administrativo apoyo gestion'  => 'Administrativo(a) de Apoyo a la Gestión',
                        'administrativo asistencial'    => 'Administrativo(a) Asistencial',
                        'auxiliar apoyo operaciones'    => 'Auxiliar de Apoyo de Operaciones',
                        'auxiliar conductor'            => 'Auxiliar Conductor',
                    ])
                    ->searchable()
                    ->suffixAction(
                        Action::make('descargar')
                            ->icon('heroicon-o-information-circle')
                            ->url('https://www.saludtarapaca.gob.cl/wp-content/uploads/2024/01/REX-N%C2%B0-5.181-DICCIONARIO-DE-COMPETENCIAS.pdf')
                            ->openUrlInNewTab() // Esto abre el enlace en una nueva pestaña
                    )
                    ->required(),
                Forms\Components\TextInput::make('places_number')
                    ->label('Cupos')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('estament.name')
                    ->label('Estamento'),
                Tables\Columns\TextColumn::make('family_position_value')
                    ->label('Familia de Cargo'),
                Tables\Columns\TextColumn::make('places_number')
                    ->label('Cupos'),
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
            ]);
            /*
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);*/
            
    }
}
