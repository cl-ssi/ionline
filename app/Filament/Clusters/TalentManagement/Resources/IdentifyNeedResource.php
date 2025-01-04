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
                                ->default(auth()->id()) // Precarga el valor del usuario autenticado
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('dv')
                                ->label('DV')
                                ->default(auth()->user()->dv) // Precarga el valor del usuario autenticado
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('full_name')
                                ->label('Funcionario')
                                ->default(auth()->user()->full_name) // Precarga el valor del usuario autenticado
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(6),
                            Forms\Components\TextInput::make('email')
                                ->label('Correo')
                                ->default(auth()->user()->email_personal) // Precarga el valor del usuario autenticado
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('organizational_email')
                                ->label('Correo Institucional')
                                ->default(auth()->user()->email) // Precarga el valor del usuario autenticado
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('organizational_unit_name')
                                ->label('Unidad Organizacional')
                                ->default(auth()->user()->organizationalUnit->name) // Precarga el valor del usuario autenticado
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(6),
                            Forms\Components\TextInput::make('position')
                                ->label('Cargo')
                                ->default(auth()->user()->position) // Precarga el valor del usuario autenticado
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(3),

                                /*

                            Forms\Components\Select::make('estament_id')
                                ->label('Estamento')
                                ->relationship('estament', 'name')
                                ->columnSpan(3)
                                ->required(),
                                */
                        ]),
                    ]),
                
                Forms\Components\Section::make('Jefatura')
                    // ->description('Prevent abuse by limiting the number of requests per period')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('boss_full_name')
                                ->label('Nombre Jefatura')
                                ->default(auth()->user()->boss->full_name)
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(6),

                            Forms\Components\TextInput::make('boss_email')
                                ->label('Correo')
                                ->default(auth()->user()->boss->email)
                                ->disabled() // Campo deshabilitado para edición
                                ->columnSpan(6),
                        ]),
                    ]),
                
                Forms\Components\Section::make('Formulario Detección Necesidades De Capacitación')
                    ->schema([
                        Grid::make(12)->schema([
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

                            Forms\Components\Radio::make('law')
                                ->label('¿Cuál es el tema específico que debería abordar esta capacitación?')
                                ->options([
                                    '18834' => 'Ley 18.834',
                                    '19664' => 'Ley 19.664',
                                    '15076' => 'Ley 15.076',
                                ])
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
                                ->columnSpan(8)
                                ->required(),
                            Forms\Components\Actions::make([
                                Forms\Components\Actions\Action::make('descargar_archivo')
                                    ->label('Descargar')
                                    // ->url(route('descargar.archivo', ['id' => $record->id])) // Ruta para descargar
                                    ->color('primary') // Color del botón
                                    ->outlined()
                            ]),

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
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('online_type_mechanism', null);
                                    $set('coffe_break', null);
                                    $set('coffe_break_price', null);
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
                                ->preload()
                                ->live()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => $get('mechanism') !== 'online')  // Deshabilita si no es "online"
                                ->visible(fn (callable $get) => $get('mechanism') === 'online')  // Visible si no es "online"
                                ->required(fn (callable $get) => $get('mechanism') === 'online'), // Requerido si es "online"
                        ]), 

                        // TIPO PRESENCIAL
                        Grid::make(12)->schema([                        
                            Forms\Components\Select::make('coffe_break')
                                ->label('¿Esta Actividad considera Coffe Break?')
                                ->options([
                                    'si' => 'Si', 
                                    'no' => 'No',
                                ])
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('coffe_break_price', null);
                                })
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => $get('mechanism') !== 'presencial') // Deshabilita si no es "presencial"
                                ->visible(fn (callable $get) => $get('mechanism') === 'presencial') // Visible solo si es "presencial"
                                ->required(fn (callable $get) => $get('mechanism') === 'presencial'), // Requerido si es "presencial"
                            Forms\Components\TextInput::make('coffe_break_price')
                                ->label('¿Cuanto es el Valor de Coffe Break?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => $get('coffe_break') !== 'si') // Deshabilita si no es "si"
                                ->visible(fn (callable $get) => $get('coffe_break') === 'si') // Visible solo si es "si"
                                ->required(fn (callable $get) => $get('coffe_break') === 'si'), // Requerido si es "presencial"
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
                                ->visible(fn (callable $get) => $get('online_type_mechanism') === 'asincronico')  // Visible si es "asincronico"
                                ->columnSpanFull(),
                            Forms\Components\Select::make('exists')
                                ->label('¿La actividad se encuentra dentro de la oferta?')
                                ->options([
                                    'si' => 'Si', 
                                    'no' => 'No',
                                ])
                                ->searchable()
                                ->preload()
                                ->live()
                                ->columnSpan(4)
                                ->visible(fn (callable $get) => $get('online_type_mechanism') === 'asincronico')
                                ->required(fn (callable $get) => $get('exists') === 'si'),
                            Forms\Components\Select::make('digital_capsule')
                                ->label('¿El curso podría ser una Capsula Digital?')
                                ->options([
                                    'si' => 'Si', 
                                    'no' => 'No',
                                ])
                                ->searchable()
                                ->preload()
                                ->live()
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => $get('exists') !== 'no') // Deshabilita si no es "presencial"
                                ->visible(fn (callable $get) => $get('exists') === 'no') // Visible solo si es "presencial"
                                ->required(fn (callable $get) => $get('exists') === 'no'), // Requerido si es "presencial"
                        ]),

                        Grid::make(12)->schema([     
                            Forms\Components\Select::make('transport')
                                ->label('¿La Actividad considera Traslado de los (las) Relatores (as)?')
                                ->options([
                                    'si' => 'Si', 
                                    'no' => 'No',
                                ])
                                ->searchable()
                                ->preload()
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
                                ->disabled(fn (callable $get) => $get('transport') !== 'si') // Deshabilita si no es "si"
                                ->required(fn (callable $get) => $get('transport') === 'si'), // Requerido si es "presencial"
                            
                            Forms\Components\Select::make('accommodation')
                                ->label('¿La Actividad considera alojamiento del o los (las) Relatores (as)?')
                                ->options([
                                    'si' => 'Si', 
                                    'no' => 'No',
                                ])
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('accommodation_price', null);
                                })
                                ->columnSpan(8)
                                ->required(),
                            Forms\Components\TextInput::make('accommodation_price')
                                ->label('¿Cuánto es el valor de traslado?')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(4)
                                ->disabled(fn (callable $get) => $get('accommodation') !== 'si')
                                ->required(fn (callable $get) => $get('accommodation') === 'si'),
                        ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListIdentifyNeeds::route('/'),
            'create' => Pages\CreateIdentifyNeed::route('/create'),
            'edit' => Pages\EditIdentifyNeed::route('/{record}/edit'),
        ];
    }
}
