<?php

namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\JobPositionProfileResource\Pages;
use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\JobPositionProfileResource\RelationManagers;
use App\Models\JobPositionProfiles\JobPositionProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;

class JobPositionProfileResource extends Resource
{
    protected static ?string $model = JobPositionProfile::class;

    protected static ?string $modelLabel = 'Perfiles de Cargos';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = TalentManagement::class;

    protected static ?string $navigationGroup = 'Perfiles de Cargo';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(function ($record) {
                        return $record->statusValue; // El valor traducido del estado
                    })
                    ->colors([
                        'primary' => 'saved',
                        'info' => 'sent',
                        'warning' => 'review',
                        'secondary' => 'pending',
                        'danger' => 'rejected',
                        'success' => 'complete',
                    ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator_and_unit')
                    ->label('Usuario Creador / Unidad Organizacional')
                    ->getStateUsing(function ($record) {
                        // Obtener el nombre completo del usuario creador
                        $creatorFullName = $record->user ? $record->user->fullName : 'Usuario no disponible';
                        // Obtener el nombre de la unidad organizacional
                        $unitName = $record->organizationalUnit ? $record->organizationalUnit->name : 'Unidad no disponible';
                        // Combinar ambos datos en una sola línea con salto de linea
                        return $creatorFullName . ' <br> ' . $unitName;
                    })
                    ->html()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre de Perfil de Cargo')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('detalle_calidad_juridica')
                    ->label('Detalle / Calidad Jurídica')
                    ->getStateUsing(function ($record) {
                        // Verifica que todas las relaciones están cargadas correctamente
                        $estamentName = $record->estament ? $record->estament->name : 'No disponible';
                        $areaName = $record->area ? $record->area->name : 'No disponible';  // Verifica que "area" sea el nombre correcto de la relación
                        // Verifica que la relación contractualCondition exista
                        $contractualCondition = $record->contractualCondition ? $record->contractualCondition : null;
                        // Condición base
                        $conditionText = 'Condición: ' . ($contractualCondition ? $contractualCondition->name : 'No disponible');
                        // Verificar si existe el grado (degree) y concatenarlo a la condición
                        if ($contractualCondition && !empty($contractualCondition->degree)) {
                            $conditionText .= ' - Grado ' . $contractualCondition->degree;  // Muestra el grado en la misma línea
                        } else {
                            $conditionText .= ' - Grado No disponible';  // Si no hay grado
                        }
                        // Devuelve la cadena final con el formato adecuado
                        return 'Estamento: ' . $estamentName . ' <br> ' .
                            'Familia del Cargo: ' . $areaName . ' <br> ' .  // Utiliza <br> como separador
                            $conditionText; // Devuelve la condición con grado si existe
                    })
                    ->html()  // Permite que se interprete el HTML
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('marco_legal')
                    ->label('Marco Legal')
                    ->getStateUsing(function ($record) {
                        // Usa los accesorios definidos en el modelo para obtener valores traducidos
                        $law = $record->lawValue; // Usando el accesorio getLawValueAttribute
                        $dfl3 = $record->dfl3Value; // Usando el accesorio getDfl3ValueAttribute
                        $dfl29 = $record->dfl29Value; // Usando el accesorio getDfl29ValueAttribute
                        $otherLegalFramework = $record->otherLegalFrameworkValue; // Usando getOtherLegalFrameworkValueAttribute
                        $workingDay = $record->working_day ? $record->working_day . ' Horas' : null; // Valor directo
                        // Crear un arreglo con los valores no nulos
                        $fields = array_filter([
                            $law ? 'Ley: ' . $law : null,
                            $dfl3,
                            $dfl29,
                            $otherLegalFramework,
                            $workingDay,
                        ]);
                        // Unir los valores con saltos de línea
                        return implode('<br>', $fields);
                    })
                    ->html()  // Permite el renderizado de HTML
                    ->searchable()
                    ->wrap(),
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
            'index' => Pages\ListJobPositionProfiles::route('/'),
            'create' => Pages\CreateJobPositionProfile::route('/create'),
            'edit' => Pages\EditJobPositionProfile::route('/{record}/edit'),
            'report-by-organizational-unit' => Pages\ReportByOrganizationalUnit::route('/report-by-organizational-unit'),
        ];
    }
}