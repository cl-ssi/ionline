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
use Illuminate\Support\Facades\Storage;
use Filament\Support\Colors;
use App\Models\ClRegion;
use App\Models\ClCommune;
use App\Models\Parameters\Parameter;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static ?string $modelLabel = 'Solicitud';

    protected static ?string $pluralModelLabel = 'Solicitudes';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

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
                                ->afterStateHydrated(function (callable $set, $record) {
                                    $set('user_full_name', $record && $record->user ? $record->user->full_name : auth()->user()->full_name ?? '');
                                })
                                ->readOnly()
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('user_id')
                                ->label('RUN')
                                ->default(fn ($record) => $record ? $record->user_id : auth()->id())
                                ->readOnly()
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('user_dv')
                                ->label('DV')
                                ->afterStateHydrated(function (callable $set, $record) {
                                    // Precarga el valor desde el usuario relacionado o el autenticado
                                    $set('user_dv', $record && $record->user ? $record->user->dv : auth()->user()->dv ?? '');
                                })
                                ->readOnly()
                                ->columnSpan(1),
                        ]),
                        Grid::make(12)->schema([
                            Forms\Components\Select::make('estament_id')
                                ->label('Estamento')
                                ->relationship('estament', 'name')
                                ->searchable()
                                ->preload()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
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
                                ->preload()
                                ->suffixAction(
                                    Action::make('descargar')
                                        ->icon('heroicon-o-information-circle')
                                        ->url('https://www.saludtarapaca.gob.cl/wp-content/uploads/2024/01/REX-N%C2%B0-5.181-DICCIONARIO-DE-COMPETENCIAS.pdf')
                                        ->openUrlInNewTab() // Esto abre el enlace en una nueva pestaña
                                )
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\Select::make('contractual_condition_id')
                                ->label('Calidad Contractual')
                                ->relationship('contractualCondition', 'name')
                                ->searchable()
                                ->preload()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
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
                                        ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                        ->required(),
                                ])->columnSpan(4), // Mantiene el mismo espacio en la grid
                            Forms\Components\TextInput::make('degree')
                                ->label('Grado')
                                ->reactive()
                                ->disabled(fn (callable $get) => 
                                    $get('law') !== '18834' || 
                                    in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])
                                )
                                ->dehydrated()
                                ->columnSpan(4),
                            Forms\Components\Select::make('work_hours')
                                ->label('Horas de Desempeño')
                                ->options([
                                    '11' => '11', 
                                    '22' => '22',
                                    '33' => '33',
                                    '44' => '44',
                                ])
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->disabled(fn (callable $get) => 
                                    $get('law') !== '19664' || 
                                    in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])
                                )
                                ->dehydrated()
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('organizational_unit_name')
                                ->label('Servicio/Unidad')
                                ->afterStateHydrated(function (callable $set, $record) {
                                    $set('organizational_unit_name', $record && $record->organizationalUnit ? $record->organizationalUnit->name : auth()->user()->organizationalUnit->name ?? '');
                                })
                                ->readOnly()
                                ->columnSpan(8),
                            Forms\Components\TextInput::make('establishment_name')
                                ->label('Establecimiento')
                                ->afterStateHydrated(function (callable $set, $record) {
                                    $set('establishment_name', $record && $record->establishment ? $record->establishment->name : auth()->user()->establishment->name ?? '');
                                })
                                ->readOnly()
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('email')
                                ->label('Correo electrónico')
                                ->default(fn ($record) => $record ? $record->email : auth()->user()->email)
                                ->readOnly()
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('telephone')
                                ->label('Teléfono')
                                ->default(fn ($record) => $record ? $record->telephone : auth()->user()->telephone)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
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
                                    \Filament\Forms\Components\Actions\Action::make('verEjesEstrategicos')
                                        ->icon('heroicon-o-information-circle')
                                        ->label('Ver Ejes Estratégicos')
                                        ->url(fn () => \App\Filament\Clusters\TalentManagement\Resources\TrainingResource\Pages\StrategicAxisList::getUrl())
                                        ->openUrlInNewTab()
                                )
                                ->columnSpan(6)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('objective')
                                ->label('Objetivo')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('activity_name')
                                ->label('Nombre de la Actividad')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
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
                                ->live()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if ($state !== 'otro') {
                                        $set('other_activity_type', null); // Limpia el campo cuando el valor no es "otro"
                                    }
                                    if(!in_array($state, ['curso', 'taller'])){
                                        $set('role_type', null); // Limpia el campo cuando el valor no es "otro"
                                    } 
                                })
                                ->preload()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('other_activity_type')
                                ->label('Nombre de Otro Tipo Actividad')
                                ->reactive()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('activity_type') !== 'otro'  || 
                                    in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'uploaded certificate', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('activity_type') === 'otro'),
                            Forms\Components\Select::make('role_type')
                                ->label('Tipo de Participación')
                                ->options([
                                    'student' => 'Estudiante',
                                    'speaker' => 'Expositor',
                                ])
                                ->searchable()
                                ->reactive()
                                ->preload()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    !in_array($get('activity_type'), ['curso',  'taller', 'jornada']) || 
                                    in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => in_array($get('activity_type'), ['curso',  'taller', 'jornada'])),
                        ]),
                        Grid::make(12)->schema([
                            Forms\Components\Select::make('region_id')
                                ->label('Región')
                                ->options(ClRegion::all()->pluck('name', 'id')->toArray())
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (is_null($state)) {
                                        $set('commune_id', null);
                                    }
                                    if ($state === '1') {
                                        $set('allowance', 'No');
                                    }
                                })
                                ->searchable()
                                ->preload()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])
                                )
                                ->dehydrated()
                                ->required(),
                            Forms\Components\Select::make('commune_id')
                                ->label('Comuna')
                                ->options(function (callable $get) {
                                    $region = ClRegion::find($get('region_id'));
                                    if(!$region){
                                        return ClCommune::all()->pluck('name', 'id');
                                    }
                                    return ClCommune::where('region_id', $get('region_id'))->pluck('name', 'id');
                                })
                                ->reactive()
                                ->searchable()
                                ->preload()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])
                                )
                                ->dehydrated()
                                ->required(),
                            Forms\Components\Group::make([
                                    Forms\Components\Radio::make('allowance')
                                        ->label('Viático')
                                        ->reactive()
                                        ->options([
                                            '1' => 'Sí',
                                            '0' => 'No',
                                        ])
                                        ->columns(4) // Organiza las opciones en 2 columnas
                                        ->disabled(/*fn (callable $get) => 
                                            $get('region_id') === '1' &&
                                            !in_array($get('status'), ['sent', 'pending certificate', 'uploaded certificate', 'completed'])
                                            */
                                            function (callable $get) {
                                                return ($get('region_id') === 1) || ($get('region_id') === '1')  ||
                                                in_array($get('status'), ['sent', 'pending certificate', 'uploaded certificate', 'completed']);
                                            }
                                        )
                                        ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                            // Si la región es 1, establece el valor '0' (No) automáticamente
                                            if ($get('region_id') === '1') {
                                                $set('allowance', '0');
                                            }
                                        })
                                        ->required(),
                                ])
                                ->columnSpan(4), // Mantiene el mismo espacio en la grid
                        ]),
                        Grid::make(12)->schema([
                            Forms\Components\Select::make('schuduled')
                                ->label('Actividad Programada')
                                ->options([
                                    'pac' => 'PAC', 
                                    'pim' => 'PIM',
                                    'no'  => 'No',
                                ])
                                ->live()
                                ->searchable()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (is_null($state)) {
                                        $set('planning_source', null);
                                    }
                                })
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\Select::make('planning_source')
                                ->label('Financiamiento')
                                ->options([
                                    'self'  => 'Auto-financiamiento',
                                    'sst'   => 'Servicio de Salud Tarapacá',
                                ])
                                ->reactive()
                                ->searchable()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('schuduled') !== 'no' &&
                                    !in_array($get('status'), ['sent', 'pending certificate', 'uploaded certificate', 'completed'])
                                )
                                ->required(),
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
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (is_null($state) || $state === 'presencial') {
                                        $set('online_type', null);
                                    }
                                    if ($state === 'online') {
                                        $set('place', null);
                                    }
                                })
                                ->preload()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\Select::make('online_type')
                                ->label('Modalidad Online')
                                ->options([
                                    'sincronico'    => 'Sincrónico', 
                                    'asincronico'   => 'Asincrónico',
                                    'mixta'         => 'Mixta',
                                ])
                                ->searchable()
                                ->reactive()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('mechanism') !== 'online' || 
                                    in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('mechanism') === 'online'),
                        ]),
                        Grid::make(12)->schema([
                            Forms\Components\DatePicker::make('activity_date_start_at')
                                ->label('Fecha Inicio de Actividad')
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\DatePicker::make('activity_date_end_at')
                                ->label('Fecha Termino de Actividad')
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('total_hours')
                                ->label('Total Horas Pedagógicas')
                                ->numeric()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\DatePicker::make('permission_date_start_at')
                                ->label('Solicita Permiso Desde')
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\DatePicker::make('permission_date_end_at')
                                ->label('Solicita Permiso Hasta')
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                        ]),
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('place')
                                ->label('Lugar de Actividad')
                                ->columnSpan(4)
                                ->reactive()
                                ->disabled(fn (callable $get) => 
                                    $get('mechanism') === 'online' || 
                                    in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('mechanism') !== 'online'),
                            Forms\Components\Select::make('working_day')
                                ->label('Jornada y Horarios')
                                ->options([
                                    'completa'  => 'Jornada Completa', 
                                    'mañana'    => 'Jornada Mañana',
                                    'tarde'     => 'Jornada Tarde',
                                ])
                                ->searchable()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('technical_reasons')
                                ->label('Fundamento o Razones Técnicas para la asistencia del funcionario')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                ->required(),
                        ]),
                    ]),
                
                Forms\Components\Section::make('Adjuntos')
                    ->schema([
                        Grid::make(12)->schema([
                            /**
                             * Ejemplo completo de uso de relación file
                             */
                            Forms\Components\Group::make()
                                ->relationship(
                                    'rejoinderFile',
                                    condition: fn (?array $state): bool => filled($state['storage_path']),
                                ) // Nombre de la relación que está con MorphOne
                                ->schema([
                                    Forms\Components\FileUpload::make('storage_path') // Ruta donde quedará almacenado el archivo
                                        ->label('Compromiso Réplica')
                                        ->directory('ionline/trainings/rejoinder')
                                        ->storeFileNamesIn('name')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->downloadable()
                                        ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])),
                                    Forms\Components\Hidden::make('type') // Campo oculto para almacenar el tipo de archivo dentro del modelo File
                                        ->default('rejoinder_file')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpanFull(),
                            /* Fin del uso de relacion MorphOne de File */
                        ]),
                        Grid::make(12)->schema([
                            /**
                             * Ejemplo completo de uso de relación file
                             */
                            Forms\Components\Group::make()
                                ->relationship(
                                    'programFile',
                                    condition: fn (?array $state): bool => filled($state['storage_path']),
                                ) // Nombre de la relación que está con MorphOne
                                ->schema([
                                    Forms\Components\FileUpload::make('storage_path') // Ruta donde quedará almacenado el archivo
                                        ->label('Programa')
                                        ->directory('ionline/trainings/program')
                                        ->storeFileNamesIn('name')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->downloadable()
                                        ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                        ->required(),
                                    Forms\Components\Hidden::make('type') // Campo oculto para almacenar el tipo de archivo dentro del modelo File
                                        ->default('program_file')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpanFull(),
                            /* Fin del uso de relacion MorphOne de File */
                        ]),
                    ]),
                Forms\Components\Section::make('Información Adicional para Certificación')
                    ->schema([
                        Grid::make(12)->schema([
                            /**
                             * Ejemplo completo de uso de relación file
                             */
                            Forms\Components\Group::make()
                                ->relationship(
                                    'certificateFile',
                                    condition: fn (?array $state): bool => filled($state['storage_path']),
                                ) // Nombre de la relación que está con MorphOne
                                ->schema([
                                    Forms\Components\FileUpload::make('storage_path') // Ruta donde quedará almacenado el archivo
                                        ->label('Certificado')
                                        ->directory('ionline/trainings/certificate')
                                        ->storeFileNamesIn('name')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->downloadable()
                                        ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed']))
                                        ->required(),
                                    Forms\Components\Hidden::make('type') // Campo oculto para almacenar el tipo de archivo dentro del modelo File
                                        ->default('certificate_file')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpanFull(),
                            /* Fin del uso de relacion MorphOne de File */

                            /**
                             * Ejemplo completo de uso de relación file
                             */
                            Forms\Components\Group::make()
                                ->relationship(
                                    'attachedFile',
                                    condition: fn (?array $state): bool => filled($state['storage_path']),
                                ) // Nombre de la relación que está con MorphOne
                                ->schema([
                                    Forms\Components\FileUpload::make('storage_path') // Ruta donde quedará almacenado el archivo
                                        ->label('Adjunto, (Si va a adjuntar documentos anexos, por favor consolídelos en un solo archivo PDF.)')
                                        ->directory('ionline/trainings/attached')
                                        ->storeFileNamesIn('name')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->downloadable()
                                        ->disabled(fn (callable $get) => in_array($get('status'), ['sent',  'pending certificate', 'uploaded certificate', 'completed'])),
                                    Forms\Components\Hidden::make('type') // Campo oculto para almacenar el tipo de archivo dentro del modelo File
                                        ->default('attached_file')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpanFull(),
                            /* Fin del uso de relacion MorphOne de File */
                        ]),
                    ])
                    ->visible(fn (callable $get) => in_array($get('status'), ['pending certificate', 'uploaded certificate'])),
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
                        'Guardado'              => 'info',
                        'Enviado'               => 'warning',
                        'Certificado Pendiente' => 'gray',
                        'Certificado Enviado'   => 'gray',
                        'Finalizado'            => 'succes',
                        'Rechazado'             => 'danger',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime('d-m-Y H:i:s'),
                Tables\Columns\TextColumn::make('user.TinyName')
                    ->label('Funcionario'),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
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
            ->defaultSort('id', 'desc')
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
            'index'                 => Pages\ListTrainings::route('/'),
            'create'                => Pages\CreateTraining::route('/create'),
            'edit'                  => Pages\EditTraining::route('/{record}/edit'),
            'strategic-axis-list'   => Pages\StrategicAxisList::route('/strategic-axis-list'),
        ];
    }
}
