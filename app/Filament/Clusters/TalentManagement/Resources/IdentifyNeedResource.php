<?php

namespace App\Filament\Clusters\TalentManagement\Resources;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource\Pages;
use App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource\RelationManagers;
use App\Models\IdentifyNeeds\IdentifyNeed;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;
use Filament\Forms\Components\Grid;
use App\Models\Trainings\ImpactObjective;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\Establishment;

class IdentifyNeedResource extends Resource
{
    protected static ?string $model = IdentifyNeed::class;

    protected static ?string $modelLabel = 'Necesidades de Capacitaciones';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = TalentManagement::class;

    protected static ?string $navigationGroup = 'DNC';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Usuario')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('user_id')
                                ->label('Funcionario')
                                ->default(fn ($record) => $record ? $record->user_id : auth()->id()) // Toma el valor del registro o del usuario autenticado
                                ->readOnly()
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('dv')
                                ->label('DV')
                                ->readOnly()
                                ->dehydrated(false) 
                                ->afterStateHydrated(function (callable $set, $record) {
                                    // Precarga el valor desde el usuario relacionado o el autenticado
                                    $set('dv', $record && $record->user ? $record->user->dv : auth()->user()->dv ?? '');
                                })
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('user_full_name')
                                ->label('Funcionario')
                                ->readOnly()
                                ->afterStateHydrated(function (callable $set, $record) {
                                    $set('user_full_name', $record && $record->user ? $record->user->full_name : auth()->user()->full_name ?? '');
                                })
                                ->columnSpan(6),
                            Forms\Components\TextInput::make('email_personal')
                                ->label('Correo')
                                ->default(fn ($record) => $record ? $record->email_personal : auth()->user()->email_personal) // Toma el valor del registro o del usuario autenticado
                                ->readOnly()
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('email')
                                ->label('Correo Institucional')
                                ->default(fn ($record) => $record ? $record->email : auth()->user()->email) // Toma el valor del registro o del usuario autenticado
                                ->readOnly()
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('organizational_unit_name')
                                ->label('Unidad Organizacional')
                                ->default(fn ($record) => $record ? $record->organizational_unit_name : auth()->user()->organizationalUnit->name) // Toma el valor del registro o del usuario autenticado
                                ->readOnly()
                                ->columnSpan(6),
                            Forms\Components\TextInput::make('position')
                                ->label('Cargo')
                                ->default(fn ($record) => $record ? $record->position : auth()->user()->position) // Toma el valor del registro o del usuario autenticado
                                ->readOnly()
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('telephone')
                                ->label('Teléfono (MINSAL)')
                                ->default(fn ($record) => $record ? $record->telephone : (auth()->user()->telephones->first()->minsal ?? '')) // Toma el valor del registro o del usuario autenticado
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending']))
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('mobile')
                                ->label('Teléfono Móvil')
                                ->prefix('+56 9')
                                ->default(fn ($record) => $record ? $record->mobile : (auth()->user()->mobile ? auth()->user()->mobile->first()->number : '')) // Toma el valor del registro o del usuario autenticado
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending']))
                                ->columnSpan(3),
                        ]),
                    ]),
                
                Forms\Components\Section::make('Jefatura')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('boss_full_name')
                                ->label('Nombre Jefatura')
                                ->readOnly()
                                ->afterStateHydrated(function (callable $set, $record) {
                                    $set('boss_full_name', $record ? $record->bossUser->full_name : ((auth()->user()->boss) ? auth()->user()->boss->full_name : 'Sin jefatura asignada'));
                                })
                                ->columnSpan(6)
                                ->required(),

                            Forms\Components\TextInput::make('boss_email')
                                ->label('Correo')
                                ->readOnly()
                                ->default(fn ($record) => $record ? $record->boss_email : (auth()->user()->boss ? auth()->user()->boss->email : null))
                                ->columnSpan(6)
                                ->required(),
                        ]),
                    ]),
                
                Forms\Components\Section::make('Formulario Detección Necesidades De Capacitación')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('subject')
                                ->label('Nombre de Actividad')
                                ->columnSpan(8)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('total_hours')
                                ->label('Horas Pedagógicas')
                                ->numeric()
                                ->minValue(20)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            /*
                            Forms\Components\Select::make('estament_id')
                                ->label('Estamento')
                                ->relationship('estament', 'name')
                                ->columnSpan(6)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending']))
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
                                ->default(null)
                                ->columnSpan(6)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending']))
                                ->required(),
                            */

                            Forms\Components\Radio::make('nature_of_the_need')
                                ->label('Naturaleza de la Necesidad')
                                ->options([
                                    'red asistencial'   => 'Red Asistencial.',
                                    'dss'               => 'Dirección Servicio de Salud.',
                                ])
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),

                            Forms\Components\Textarea::make('question_1')
                                ->label('¿Cuál es el principal desafío o problema que enfrenta y que podría resolverse a través de una capacitación?')
                                ->placeholder('Ejemplo: Falta de conocimiento técnico, cumplimiento de normativas, falta desarrollo de habilidades transversales, entre otros.')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),

                            Forms\Components\Textarea::make('question_2')
                                ->label('¿Esta necesidad de capacitación afecta el cumplimiento de algún objetivo estratégico, meta o compromiso de gestión en su área o en la institución?')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),

                            Forms\Components\Textarea::make('question_3')
                                ->label('¿Qué habilidades o conocimientos específicos considera que se necesita mejorar para un mejor desempeño?.')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),

                            Forms\Components\Textarea::make('question_4')
                                ->label('¿Cuál es el tema específico que debería abordar esta capacitación?')
                                ->placeholder('Ejemplo: Liderazgo, manejo de conflictos, herramientas tecnológicas, normativas específicas.')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            /*
                            Forms\Components\CheckboxList::make('law')
                                ->label('Esta actividad esta dirigida para funcionarios o funcionarias de la Ley')
                                ->options([
                                    '18834' => 'Ley 18.834',
                                    '19664' => 'Ley 19.664',
                                    '15076' => 'Ley 15.076',
                                ])
                                ->default(fn ($record) => $record ? $record->law : []) // Decodifica JSON a array
                                ->reactive() // Hace que el campo sea reactivo a los cambios
                                ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                    $laws = collect($state);

                                    // Si se selecciona '15076', agrega '19664' si no está ya en la lista
                                    if ($laws->contains('15076') && !$laws->contains('19664')) {
                                        $laws->push('19664');
                                    }

                                    // Si se desmarca '15076', no elimina '19664' si este fue seleccionado manualmente
                                    if (!$laws->contains('15076') && $laws->contains('19664')) {
                                        $originalState = collect($get('law')); // Estado original antes de la actualización

                                        // Si '19664' no estaba agregado automáticamente por '15076', lo mantenemos
                                        if (!$originalState->contains('15076')) {
                                            $laws = $laws->reject(fn ($item) => $item === '15076'); // Solo elimina '15076'
                                        }
                                    }

                                    $set('law', $laws->unique()->toArray()); // Actualiza el estado eliminando duplicados
                                })
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending']))
                                ->required(),
                            */

                            Forms\Components\Radio::make('law')
                                ->label('Esta actividad está dirigida para funcionarios o funcionarias de la Ley')
                                ->options([
                                    '18834' => 'Ley 18.834',
                                    '19664' => 'Ley 19.664 (o Ley 15.076)',
                                ])
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),

                            Forms\Components\Textarea::make('question_5')
                                ->label('¿Qué objetivo se espera alcanzar con esta capacitación?')
                                ->placeholder('Ejemplo: Desarrollar habilidades de liderazgo inclusivo, mejorar la comunicación interna, reforzar el conocimiento técnico.')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),

                            Forms\Components\Textarea::make('question_6')
                                ->label('¿Qué resultados inmediatos espera lograr después de esta capacitación?')
                                ->placeholder('Ejemplo: Desarrollar habilidades de liderazgo inclusivo, mejorar la comunicación interna, reforzar el conocimiento técnico.')
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            
                            Forms\Components\Select::make('training_type')
                                ->label('¿Qué tipo de capacitación considera que seria mejor para abordar esta necesidad?')
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
                                        $set('other_training_type', null); // Limpia el campo cuando el valor no es "otro"
                                    }
                                })
                                ->columnSpan(8)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('other_training_type')
                                ->label('Otro tipo de capacitación')
                                ->reactive() // Reactivo al cambio de otros campos
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('training_type') !== 'otro' || 
                                    in_array($get('status'), ['pending', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('training_type') === 'otro'), // Obligatorio si es "otro"

                            Forms\Components\Select::make('strategic_axis_id')
                                ->label('¿Con qué Objetivo Estratégico se relaciona esta Actividad?')
                                ->relationship('strategicAxis', 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(fn (Set $set) => $set('impact_objective_id', null))
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),

                            Forms\Components\Select::make('impact_objective_id')
                                ->label('Objetivos de Impacto')
                                ->options(fn (GET $get): Collection => ImpactObjective::query()
                                    ->where('strategic_axis_id', $get('strategic_axis_id'))
                                    ->pluck('description', 'id'))
                                ->searchable()
                                ->preload()
                                ->columnSpanFull()
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),

                            Forms\Components\Select::make('mechanism')
                                ->label('¿Qué modalidad prefiere?')
                                ->options([
                                    'online'            => 'Online', 
                                    'presencial'        => 'Presencial',
                                    'semipresencial'    => 'Semipresencial',
                                ])
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (is_null($state) || $state === 'presencial') {
                                        $set('coffee_break', null);
                                        $set('coffee_break_price', null);
                                        $set('online_type_mechanism', null);
                                        $set('exists', null);
                                        $set('digital_capsule', null);
                                    }
                                })
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            /*
                            Forms\Components\TextInput::make('places')
                                ->label('¿Cuantas cupos considera esta actividad?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending']))
                                ->required(),
                            */
                        ]), 

                        // TIPO PRESENCIAL
                        Grid::make(12)->schema([          
                            Forms\Components\Select::make('coffee_break')
                                ->label('¿Esta Actividad considera Coffee Break?')
                                ->options([
                                    '1' => 'Si', 
                                    '0' => 'No',
                                ])
                                ->searchable()
                                ->live()
                                ->columnSpan(4)
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (is_null($state) || $state === '0') {
                                        $set('coffee_break_price', null); // Limpia el valor del campo
                                    }
                                })
                                ->disabled(fn (callable $get) => 
                                    $get('mechanism') !== 'presencial' || 
                                    in_array($get('status'), ['pending', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('mechanism') === 'presencial'),
                            
                            Forms\Components\TextInput::make('coffee_break_price')
                                ->label('¿Cuanto es el Valor de Coffe Break?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('coffee_break') !== '1' || 
                                    in_array($get('status'), ['pending', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('coffee_break') === '1'),
                        ]),

                        // TIPO ONLINE
                        Grid::make(12)->schema([
                            Forms\Components\Select::make('online_type_mechanism')
                                ->label('Modalidad Online')
                                ->options([
                                    'sincronico'    => 'Sincrónico', 
                                    'asincronico'   => 'Asincrónico',
                                    'mixta'         => 'Mixta',
                                ])
                                ->searchable()
                                ->live()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('mechanism') !== 'online' || 
                                    in_array($get('status'), ['pending', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('mechanism') === 'online'),
                        ]),

                        //TIPO ASINCRONICO
                        Grid::make(12)->schema([     
                            Forms\Components\Placeholder::make('notas')
                                ->hiddenLabel()
                                ->content(new HtmlString('
                                    <strong>Para conocer la oferta de capsulas digitales y cursos asincrónicos, visita los siguientes Links</strong>: <br>

                                    1) Oferta del Departamento de Gestión y Desarrollo del Talento:  <a href="https://gestiontalento.saludtarapaca.gob.cl/" target="_blank">https://gestiontalento.saludtarapaca.gob.cl/</a> <br>
                                    2) Dirección Nacional del Servicio Civil: <a href="https://campus.serviciocivil.cl/"  target="_blank">https://campus.serviciocivil.cl/</a> <br>
                                    ')
                                )
                                ->columnSpanFull(),
                            Forms\Components\Select::make('exists')
                                ->label('¿La actividad se encuentra dentro de la oferta?')
                                ->options([
                                    '1' => 'Si', 
                                    '0' => 'No',
                                ])
                                ->searchable()
                                ->live()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('online_type_mechanism') !== 'asincronico' || 
                                    in_array($get('status'), ['pending', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('online_type_mechanism') === 'asincronico'),

                            Forms\Components\Select::make('digital_capsule')
                                ->label('¿El curso podría ser una Capsula Digital?')
                                ->options([
                                    '1' => 'Si', 
                                    '0' => 'No',
                                ])
                                ->searchable()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('exists') !== '1' || 
                                    in_array($get('status'), ['pending', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('exists') === '1'),
                        ]),

                        Grid::make(12)->schema([     
                            Forms\Components\Select::make('transport')
                                ->label('¿La Actividad considera Traslado de los (las) Relatores (as)?')
                                ->options([
                                    '1' => 'Si', 
                                    '0' => 'No',
                                ])
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (is_null($state) || $state === '0') {
                                        $set('transport_price', null);
                                    }
                                })
                                ->columnSpan(8)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('transport_price')
                                ->label('¿Cuánto es el valor de traslado?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('transport') !== '1' || 
                                    in_array($get('status'), ['pending', 'completed'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('transport') === '1'), // Requerido si es "presencial"
                            
                            Forms\Components\Select::make('accommodation')
                                ->label('¿La Actividad considera alojamiento del o los (las) Relatores (as)?')
                                ->options([
                                    '1' => 'Si', 
                                    '0' => 'No',
                                ])
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (is_null($state) || $state === '0') {
                                        $set('accommodation_price', null);
                                    }
                                })
                                ->columnSpan(8)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                            Forms\Components\TextInput::make('accommodation_price')
                                ->label('¿Cuánto es el valor de alojamiento?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => 
                                    $get('accommodation') !== '1' || 
                                    in_array($get('status'), ['pending'])
                                )
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('accommodation') === '1'),
                            Forms\Components\TextInput::make('activity_value')
                                ->label('¿Valor de la actividad? (Excluye Coffee, Traslado y Alojamiento)')
                                ->numeric()
                                ->minValue(0)
                                ->columnSpan(8)
                                ->disabled(fn (callable $get) => in_array($get('status'), ['pending', 'completed']))
                                ->required(),
                        ])
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime('d-m-Y H:i:s'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(fn ($record) => $record->status_value)
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Guardado'      => 'info',
                        'Pendiente'     => 'warning',
                        'Finalizado'    => 'success',
                        'Rechazado'     => 'danger',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('user.TinyName')
                    ->label('Funcionario'),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
                    ->label('Unidad Organizacional'),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Nombre de Actividad'),
                Tables\Columns\TextColumn::make('total_value')
                    ->label('$')
                    ->getStateUsing(fn ($record) => number_format($record->total_value, 0, ',', '.') . ' CLP')
                    ->sortable()
                    ->alignment('right'),
                Tables\Columns\TextColumn::make('approvals.status')
                    ->label('Firmas')
                    ->bulleted()
                    ->getStateUsing(function ($record) {
                        return $record->approvals->map(function ($approval) {
                            return $approval->initials. ' - ' .$approval->status_in_words;
                        });
                    })
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                // Filtro por Estado
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'saved'     => 'Guardado',
                        'completed' => 'Finalizado',
                        'rejected'  => 'Rechazado',
                    ])
                    ->multiple()
                    ->searchable(),

                // Filtro por Unidad Organizacional
                Tables\Filters\SelectFilter::make('organizational_unit_id')
                    ->label('Unidad Organizacional')
                    ->relationship('organizationalUnit', 'name', fn (Builder $query) => $query->where('establishment_id', 38))
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(5)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AvailablePlacesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIdentifyNeeds::route('/'),
            'create' => Pages\CreateIdentifyNeed::route('/create'),
            'edit' => Pages\EditIdentifyNeed::route('/{record}/edit'),
        ];
    }
}
