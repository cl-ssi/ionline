<?php

namespace App\Filament\Clusters\TalentManagement\Resources;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\TrainingResource\Pages;
use App\Filament\Clusters\TalentManagement\Resources\TrainingResource\RelationManagers;
use App\Models\Trainings\Training;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Actions\Action;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static ?string $modelLabel = 'Solicitud';

    protected static ?string $pluralModelLabel = 'Solicitudes';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = TalentManagement::class;

    protected static ?string $navigationGroup = 'Permisos de Capacitación';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Antecedentes del funcionario/a que asiste a la Capacitación')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('user_full_name')
                                ->label('Funcionario')
                                ->default(fn ($record) => $record ? $record->userTraining->full_name : auth()->user()->full_name)
                                ->readOnly()
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('user_training_id')
                                ->label('RUN')
                                ->default(fn ($record) => $record ? $record->user_training_id : auth()->id())
                                ->readOnly()
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('user_training_dv')
                                ->label('DV')
                                ->default(fn ($record) => $record ? $record->userTraining->dv : auth()->user()->dv)
                                ->readOnly()
                                ->columnSpan(1),
                        ]),
                        Grid::make(12)->schema([
                            Forms\Components\Select::make('estament_id')
                                ->label('Estamento')
                                ->relationship('estament', 'name')
                                ->searchable()
                                ->preload()
                                // ->live()
                                // ->afterStateUpdated(fn (Set $set) => $set('impact_objective_id', null))
                                ->columnSpan(4)
                                // ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            Forms\Components\Select::make('contractual_condition_id')
                                ->label('Calidad Contractual')
                                ->relationship('contractualCondition', 'name')
                                ->searchable()
                                ->preload()
                                // ->live()
                                // ->afterStateUpdated(fn (Set $set) => $set('impact_objective_id', null))
                                ->columnSpan(4)
                                // ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            Forms\Components\Group::make([
                                    Forms\Components\Radio::make('law')
                                        ->label('Ley')
                                        ->options([
                                            '18834' => 'Ley 18.834',
                                            '19664' => 'Ley 19.664',
                                        ])
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            if ($state === '18834') {
                                                $set('degree', '');
                                                $set('work_hours', null);
                                            } else {
                                                $set('work_hours', '');
                                                $set('degree', null);
                                            }
                                        })
                                        ->columns(2) // Organiza las opciones en 2 columnas
                                        ->required(),
                                ])->columnSpan(4), // Mantiene el mismo espacio en la grid
                            Forms\Components\TextInput::make('degree')
                                ->label('Grado')
                                ->disabled(fn (callable $get) => $get('law') !== '18834')
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('work_hours')
                                ->label('Horas de Desempeño')
                                ->numeric()
                                ->disabled(fn (callable $get) => $get('law') !== '19664')
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('organizational_unit_id')
                                ->label('Servicio/Unidad')
                                ->default(fn ($record) => $record ? $record->userTraining->organizationalUnit->name : auth()->user()->organizationalUnit->name)
                                ->readOnly()
                                ->columnSpan(8),
                            Forms\Components\TextInput::make('establishment_id')
                                ->label('Servicio/Unidad')
                                ->default(fn ($record) => $record ? $record->userTraining->establishment->name : auth()->user()->establishment->name)
                                ->readOnly()
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('email')
                                ->label('Correo electrónico')
                                ->default(fn ($record) => $record ? $record->userTraining->email : auth()->user()->email)
                                ->readOnly()
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('telephone')
                                ->label('Teléfono')
                                ->default(fn ($record) => $record ? $record->userTraining->telephone : auth()->user()->telephone)
                                ->readOnly()
                                ->columnSpan(4),
                        ]),
                    ]),
                
                Forms\Components\Section::make('Antecedentes de la Actividad')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\Select::make('strategic_axes_id')
                                ->label('Eje estratégico asociados a la Actividad')
                                ->relationship('strategicAxis', 'name')
                                ->searchable()
                                ->preload()
                                ->suffixAction(
                                    Action::make('descargar')
                                        ->icon('heroicon-o-information-circle')
                                        // ->url('https://www.saludtarapaca.gob.cl/wp-content/uploads/2024/01/REX-N%C2%B0-5.181-DICCIONARIO-DE-COMPETENCIAS.pdf')
                                        ->openUrlInNewTab() // Esto abre el enlace en una nueva pestaña
                                )
                                ->columnSpan(6)
                                ->required(),
                            Forms\Components\TextInput::make('objective')
                                ->label('Objetivo')
                                ->columnSpanFull()
                                ->required(),
                            Forms\Components\TextInput::make('activity_name')
                                ->label('Nombre de la Actividad')
                                ->columnSpanFull()
                                ->required(),
                            Forms\Components\Select::make('activity_type')
                                ->label('Tipo de Actividad')
                                ->options([
                                    'curso'                         => 'Curso', 
                                    'taller'                        => 'Taller',
                                    'jornada'                       => 'Jornada',
                                    'estadia pasantia'              => 'Estadía Pasantía',
                                    'perfeccionamiento diplomado'   => 'Perfeccionamiento Diplomado',
                                    'otro'                          => 'Otro',
                                ])
                                ->searchable()
                                ->preload()
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\TextInput::make('other_activity_type')
                                ->label('Nombre de Otro Tipo Actividad')
                                ->columnSpan(4)
                                ->required(),
                        ]),
                        Grid::make(12)->schema([
                            Forms\Components\Select::make('activity_in')
                                ->label('Nacional / Internacional')
                                ->options([
                                    'national'      => 'Nacional', 
                                    'international' => 'Internacional',
                                ])
                                ->searchable()
                                ->preload()
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\Group::make([
                                    Forms\Components\Radio::make('allowance')
                                        ->label('Viático')
                                        ->options([
                                            '1' => 'Sí',
                                            '0' => 'No',
                                        ])
                                        ->columns(4) // Organiza las opciones en 2 columnas
                                        ->required(),
                                ])->columnSpan(4), // Mantiene el mismo espacio en la grid
                        ]),
                        Grid::make(12)->schema([
                            Forms\Components\Select::make('mechanism')
                                ->label('Modalidad de aprendizaje')
                                ->options([
                                    'online'            => 'Online', 
                                    'presencial'        => 'Presencial',
                                    'semipresencial'    => 'Semipresencial',
                                ])
                                ->searchable()
                                ->live()
                                ->preload()
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\Select::make('online_type')
                                ->label('Modalidad Online')
                                ->options([
                                    'sincronico'    => 'Sincrónico', 
                                    'asincronico'   => 'Asincrónico',
                                    'mixta'         => 'Mixta',
                                ])
                                ->searchable()
                                // ->live()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('mechanism') !== 'online' /*|| 
                                    in_array($get('status'), ['pending', 'completed'])*/
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('mechanism') === 'online'),
                            Forms\Components\Select::make('schuduled')
                                ->label('Actividad Programada')
                                ->options([
                                    'pac'               => 'Programada en PAC', 
                                    'no planificada'    => 'No planificada',
                                ])
                                ->searchable()
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\DatePicker::make('activity_date_start_at')
                                ->label('Fecha Inicio de Actividad')
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\DatePicker::make('activity_date_end_at')
                                ->label('Fecha Termino de Actividad')
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\TextInput::make('total_hours')
                                ->label('Total Horas Pedagógicas')
                                ->numeric()
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\DatePicker::make('permission_date_start_at')
                                ->label('Solicita Permiso Desde')
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\DatePicker::make('permission_date_end_at')
                                ->label('Solicita Permiso Hasta')
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\TextInput::make('place')
                                ->label('Lugar')
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\Select::make('Jornada y Horarios')
                                ->label('Actividad Programada')
                                ->options([
                                    'completa'  => 'Jornada Completa', 
                                    'mañana'    => 'Jornada Mañana',
                                    'tarde'     => 'Jornada Tarde',
                                ])
                                ->searchable()
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\TextInput::make('activity_name')
                                ->label('Fundamento o Razones Técnicas para la asistencia del funcionario')
                                ->columnSpanFull()
                                ->required(),
                        ]),
                    ]),
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
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(fn ($record) => $record->status_value)
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Certificado Pendiente'     => 'gray',
                        'Finalizado'                => 'success',
                        'Enviado'                   => 'primary',
                        'Guardado'                  => 'info',
                        'Rechazado'                 => 'danger',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime('d-m-Y H:i:s'),
                Tables\Columns\TextColumn::make('userTraining.TinyName')
                    ->label('Funcionario'),
                Tables\Columns\TextColumn::make('userTrainingOu.name')
                    ->label('Unidad Organizacional'),
                Tables\Columns\TextColumn::make('activity_name')
                    ->label('Nombre de la Actividad')
                    ->limit(50) // Limita el texto a 50 caracteres
                    ->tooltip(fn ($record) => $record->activity_name), // Muestra el texto completo al pasar el mouse,
                Tables\Columns\TextColumn::make('activity_date_start_at')
                    ->label('Inicio')
                    ->dateTime('d-m-Y'),
                Tables\Columns\TextColumn::make('activity_date_end_at')
                    ->label('termino')
                    ->dateTime('d-m-Y'),
                Tables\Columns\ImageColumn::make('approvals.avatar')
                    ->label('Aprobaciones')
                    ->circular()
                    ->sortable(),
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
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
        ];
    }
}
