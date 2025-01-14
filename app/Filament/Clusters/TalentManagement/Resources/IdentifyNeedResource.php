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

class IdentifyNeedResource extends Resource
{
    protected static ?string $model = IdentifyNeed::class;

    protected static ?string $modelLabel = 'Necesidades de Capacitaciones';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = TalentManagement::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Usuario')
                    // ->description('Prevent abuse by limiting the number of requests per period')
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
                        ]),
                    ]),
                
                Forms\Components\Section::make('Jefatura')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('boss_full_name')
                                ->label('Nombre Jefatura')
                                ->readOnly()
                                ->afterStateHydrated(function (callable $set, $record) {
                                    $set('boss_full_name', $record && $record->user && $record->user->boss ? $record->user->boss->full_name : auth()->user()->boss->full_name ?? '');
                                })
                                ->columnSpan(6),

                            Forms\Components\TextInput::make('boss_email')
                                ->label('Correo')
                                ->readOnly()
                                ->default(fn ($record) => $record ? $record->boss_email : auth()->user()->boss->email)
                                ->columnSpan(6),
                        ]),
                    ]),
                
                Forms\Components\Section::make('Formulario Detección Necesidades De Capacitación')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('subject')
                                ->label('Asunto')
                                ->columnSpanFull()
                                ->disabledOn('edit')
                                ->required(),
                            Forms\Components\Select::make('estament_id')
                                ->label('Estamento')
                                ->relationship('estament', 'name')
                                ->columnSpan(6)
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
                                ->suffixAction(
                                    Action::make('descargar')
                                        ->icon('heroicon-o-information-circle')
                                        ->url('https://www.saludtarapaca.gob.cl/wp-content/uploads/2024/01/REX-N%C2%B0-5.181-DICCIONARIO-DE-COMPETENCIAS.pdf')
                                        ->openUrlInNewTab() // Esto abre el enlace en una nueva pestaña
                                )
                                ->default(null)
                                ->columnSpan(6)
                                ->required(),

                            Forms\Components\CheckboxList::make('nature_of_the_need')
                                ->label('Naturaleza de la Necesidad')
                                ->options([
                                    'necesidad propia'                  => 'A una necesidad propia, relacionada con las funciones específicas que desempeño.',
                                    'necesidad de mi equipo de trabajo' => 'A una necesidad de mi equipo de trabajo, considerando el desarrollo de habilidades colectivas.',
                                    'necesidad de otros equipos'        => 'A una necesidad de otros equipos, con los que me relaciono directamente en mi gestión u operatividad. (deberás responder las preguntas de la sección "otros equipos")',
                                ])
                                ->default(fn ($record) => $record ? $record->nature_of_the_need : []) // Decodifica JSON a array
                                ->columnSpanFull()
                                ->required(),

                            Forms\Components\Textarea::make('question_1')
                                ->label('¿Cuál es el principal desafío o problema que enfrenta y que podría resolverse a través de una capacitación?')
                                ->placeholder('Ejemplo: Falta de conocimiento técnico, cumplimiento de normativas, falta desarrollo de habilidades transversales, entre otros.')
                                ->columnSpanFull()
                                ->required(),

                            Forms\Components\Textarea::make('question_2')
                                ->label('¿Esta necesidad de capacitación afecta el cumplimiento de algún objetivo estratégico, meta o compromiso de gestión en su área o en la institución?')
                                ->columnSpanFull()
                                ->required(),

                            Forms\Components\Textarea::make('question_3')
                                ->label('¿Qué habilidades o conocimientos específicos considera que se necesita mejorar para un mejor desempeño?.')
                                ->columnSpanFull()
                                ->required(),

                            Forms\Components\Textarea::make('question_4')
                                ->label('¿Cuál es el tema específico que debería abordar esta capacitación?')
                                ->placeholder('Ejemplo: Liderazgo, manejo de conflictos, herramientas tecnológicas, normativas específicas.')
                                ->columnSpanFull()
                                ->required(),

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
                                ->required(),

                            Forms\Components\Textarea::make('question_5')
                                ->label('¿Qué objetivo se espera alcanzar con esta capacitación?')
                                ->placeholder('Ejemplo: Desarrollar habilidades de liderazgo inclusivo, mejorar la comunicación interna, reforzar el conocimiento técnico.')
                                ->columnSpanFull()
                                ->required(),

                            Forms\Components\Textarea::make('question_6')
                                ->label('¿Qué resultados inmediatos espera lograr después de esta capacitación?')
                                ->placeholder('Ejemplo: Desarrollar habilidades de liderazgo inclusivo, mejorar la comunicación interna, reforzar el conocimiento técnico.')
                                ->columnSpanFull()
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
                                ->default(null)
                                ->reactive() // Permite que el cambio de estado actualice other_training_type
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if ($state !== 'otro') {
                                        $set('other_training_type', null); // Limpia el campo cuando el valor no es "otro"
                                    }
                                })
                                ->columnSpan(8)
                                ->required(),
                            Forms\Components\TextInput::make('other_training_type')
                                ->label('Otro tipo de capacitación')
                                ->reactive() // Reactivo al cambio de otros campos
                                ->disabled(fn (callable $get) => $get('training_type') !== 'otro') // Deshabilita si no es "otro"
                                ->columnSpan(4)
                                ->required(fn (callable $get) => $get('training_type') === 'otro'), // Obligatorio si es "otro"

                            Forms\Components\Select::make('strategic_axis_id')
                                ->label('¿Con qué Objetivo Estratégico se relaciona esta Actividad?')
                                ->relationship('strategicAxis', 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(fn (Set $set) => $set('impact_objective_id', null))
                                ->columnSpanFull()
                                ->required(),

                            Forms\Components\Select::make('impact_objective_id')
                                ->label('Objetivos de Impacto')
                                ->options(fn (GET $get): Collection => ImpactObjective::query()
                                    ->where('strategic_axis_id', $get('strategic_axis_id'))
                                    ->pluck('description', 'id'))
                                ->searchable()
                                ->preload()
                                ->columnSpanFull()
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
                                ->required(),

                            Forms\Components\TextInput::make('places')
                                ->label('¿Cuantas cupos considera esta actividad?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->required(),
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
                                ->disabled(fn (callable $get) => $get('mechanism') !== 'presencial') // Deshabilita si no es "si",
                                ->dehydrated()
                                ->required(fn (callable $get) => $get('mechanism') === 'presencial'),
                            
                            Forms\Components\TextInput::make('coffee_break_price')
                                ->label('¿Cuanto es el Valor de Coffe Break?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => $get('coffee_break') !== '1')
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
                                ->disabled(fn (callable $get) => $get('mechanism') !== 'online')
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
                                ->disabled(fn (callable $get) => $get('online_type_mechanism') !== 'asincronico')
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
                                ->disabled(fn (callable $get) => $get('exists') !== '1')
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
                                ->afterStateUpdated(function (Set $set) {
                                    $set('transport_price', null);
                                })
                                ->columnSpan(8)
                                ->required(),
                            Forms\Components\TextInput::make('transport_price')
                                ->label('¿Cuánto es el valor de traslado?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => $get('transport') !== '1') // Deshabilita si no es "si"
                                ->required(fn (callable $get) => $get('transport') === '1'), // Requerido si es "presencial"
                            
                            Forms\Components\Select::make('accommodation')
                                ->label('¿La Actividad considera alojamiento del o los (las) Relatores (as)?')
                                ->options([
                                    '1' => 'Si', 
                                    '0' => 'No',
                                ])
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('accommodation_price', null);
                                })
                                ->columnSpan(8)
                                ->required(),
                            Forms\Components\TextInput::make('accommodation_price')
                                ->label('¿Cuánto es el valor de alojamiento?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => $get('accommodation') !== '1')
                                ->required(fn (callable $get) => $get('accommodation') === '1'),
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
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('user.TinyName')
                    ->label('Funcionario'),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
                    ->label('Unidad Organizacional'),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto'),
                Tables\Columns\TextColumn::make('estament.name')
                    ->label('Estamento'),
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
            'index' => Pages\ListIdentifyNeeds::route('/'),
            'create' => Pages\CreateIdentifyNeed::route('/create'),
            'edit' => Pages\EditIdentifyNeed::route('/{record}/edit'),
        ];
    }
}
