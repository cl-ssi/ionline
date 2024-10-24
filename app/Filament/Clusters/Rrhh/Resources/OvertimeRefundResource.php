<?php

namespace App\Filament\Clusters\Rrhh\Resources;

use App\Filament\Clusters\Rrhh;
use App\Filament\Clusters\Rrhh\Resources\OvertimeRefundResource\Pages;
use App\Models\Rrhh\Attendance;
use App\Models\Rrhh\OvertimeRefund;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class OvertimeRefundResource extends Resource
{
    protected static ?string $model = OvertimeRefund::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Rrhh::class;

    protected static ?string $modelLabel = 'Devolución de horas';

    protected static ?string $pluralModelLabel = 'Devoluciones de horas';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->hiddenLabel()
                            ->live()
                            ->required(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('Buscar')
                                ->action(function (Get $get, Set $set) {
                                    $attendance = Attendance::where('user_id', auth()->id())
                                        ->whereDate('date', $get('date'))
                                        ->first();
                                
                                    if ($attendance) {
                                        $set('attendance', $attendance);
                                
                                        // Obtener detalles de overTimeRefundDetails
                                        $overTimeRefundDetails = $attendance->overTimeRefundDetails;
                                
                                        // Obtener detalles de $record->details
                                        $recordDetails = $get('details') ?? [];
                                
                                        // Función para fusionar los detalles
                                        $mergedDetails = array_map(function ($detail) use ($recordDetails) {
                                            // Buscar el detalle correspondiente en $recordDetails
                                            $recordDetail = collect($recordDetails)->firstWhere('date', $detail['date']);
                                
                                            // Si no existe, completar con valores predeterminados
                                            if (!$recordDetail) {
                                                $recordDetail = [
                                                    'hours_day' => 0,
                                                    'hours_night' => 0,
                                                    'active' => false,
                                                    'justification' => null,
                                                ];
                                            }
                                
                                            // Fusionar los detalles, manteniendo la primera columna de overTimeRefundDetails
                                            return array_merge($detail, array_intersect_key($recordDetail, array_flip(['hours_day', 'hours_night', 'active', 'justification'])));
                                        }, $overTimeRefundDetails);
                                
                                        $set('details', $mergedDetails);
                                        $set('grado', $attendance->grado);
                                    }
                                    else {
                                        $set('attendance', null);
                                    }
                                }),
                        ]),
                    ])
                    ->columns(5),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('grado')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('planta')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\Radio::make('type')
                            ->label('Tipo')
                            ->options([
                                'pay'    => 'Pago',
                                'return' => 'Devolución',
                            ])
                            ->inline()
                            ->inlineLabel(false)
                            ->required(),
                        Forms\Components\Placeholder::make('Jefatura')
                            ->content(fn (): int|string|null => auth()->user()->boss->shortName),
                        Forms\Components\Placeholder::make('Cargo de la jefatura')
                            ->content(fn (): int|string|null => auth()->user()->boss->position),

                        Forms\Components\Repeater::make('details')
                            ->schema([
                                Forms\Components\DatePicker::make('date')
                                    ->label('Fecha')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('overtime')
                                    ->label('Horas extras')
                                    ->disabled()
                                    ->columnSpan(2),
                                Forms\Components\Toggle::make('active')
                                    ->label('Contar')
                                    ->required()
                                    ->inline(false),
                                Forms\Components\TextInput::make('hours_day')
                                    ->label('Horas diurnas')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('hours_night')
                                    ->label('Horas nocturnas')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('justification')
                                    ->label('Justificación')
                                    ->maxLength(255)
                                    ->columnSpan(3)
                                    ->requiredIf('active',true),
                            ])
                            ->columns(12)
                            ->columnSpanFull()
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false),

                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('calcular')
                                ->action(function (Get $get, Set $set) {
                                    $items         = $get('details') ?? [];
                                    $totalMinutesDay = array_reduce($items, function ($carry, $item) {
                                        if (isset($item['active']) && $item['active']) {
                                            return $carry + ($item['hours_day'] ?? 0);
                                        }

                                        return $carry;
                                    }, 0);
                                    $totalMinutesNight = array_reduce($items, function ($carry, $item) {
                                        if (isset($item['active']) && $item['active']) {
                                            return $carry + ($item['hours_night'] ?? 0);
                                        }

                                        return $carry;
                                    }, 0);
                    
                                    // Función para convertir minutos a horas y minutos
                                    $convertMinutesToHoursAndMinutes = function ($totalMinutes) {
                                        $hours = floor($totalMinutes / 60);
                                        $minutes = $totalMinutes % 60;
                                        return sprintf('%02dH:%02dm', $hours, $minutes);
                                    };

                                    $totalHoursDay = $convertMinutesToHoursAndMinutes($totalMinutesDay);
                                    $totalHoursNight = $convertMinutesToHoursAndMinutes($totalMinutesNight);

                                    $set('total_hours_day', $totalHoursDay);
                                    $set('total_hours_night', $totalHoursNight);
                                    $set('total_minutes_day', $totalMinutesDay);
                                    $set('total_minutes_night', $totalMinutesNight);
                                }),
                            ])
                            ->columnSpanFull(),
        
                        Forms\Components\TextInput::make('total_minutes_day')
                            ->label('Total minutos diurnos')
                            ->numeric()
                            ->readOnly(),
                        Forms\Components\TextInput::make('total_hours_day')
                            ->label('Total horas diurnas')
                            ->readOnly(),
                        Forms\Components\TextInput::make('total_minutes_night')
                            ->label('Total minutos nocturnos')
                            ->numeric()
                            ->readOnly(),
                        Forms\Components\TextInput::make('total_hours_night')
                            ->label('Total horas nocturnas')
                            ->readOnly(),

                        Forms\Components\Placeholder::make('notas')
                            ->hiddenLabel()
                            ->content(new HtmlString('
                                <strong>NOTAS</strong><br>
                                1. Las horas extraordinarias solicitadas serán valorizadas y previamente evaluadas para su autorización, modificación o rechazo.<br>
                                2. Las fundamentaciones de las horas extras solicitadas deben ser claras y específicas (no siendo generalizadas), de lo contrario se dejará sin efecto esa solicitud.<br>
                                3. El tope de horas extraordinarias diurnas corresponde a 40 horas mensuales, las cuales están establecidas por ley.<br>
                                4. Las horas extraordinarias nocturnas no mantienen un tope legal, pero deben ajustarse a las necesidades de cada servicio o unidad.<br>
                                5. Cualquier duda o consulta dirigirse a la U. de GESTIÓN de P. y C.V.L.
                                ')
                            )
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('articulo')
                            ->hiddenLabel()
                            ->content(new HtmlString('
                                    <strong>Articulo 66, Estatuto Administrativo:</strong> El jefe superior de la institución, el Secretario Regional Ministerial o 
                                    el Director Regional de servicios nacionales desconcentrados, según corresponda, podrá ordenar trabajos 
                                    extraordinarios a continuación de la jornada ordinaria, de noche o en días sábado, domingo y festivos, 
                                    cuando hayan de cumplirse tareas impostergables.<br>
                                    1. Para las jornadas de 44 horas se contabiliza como hora extraordinaria a partir del minuto 30.<br>
                                    2. La jornada extraordinaria nocturna se contempla entre las 21:00 horas hasta las 07:00 horas, sábados y domingos y festivos.<br>
                                    3. La jornada extraordinaria diurna se contempla entre las 08:00 horas hasta 21:00 horas.<br>
                                ')
                            )
                            ->columnSpanFull(),

                    ])
                    ->columns(5)
                    ->hidden(fn (Get $get) => !$get('attendance')),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.shortName')
                    ->label('Usuario')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date('Y-m')
                    ->sortable(),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
                    ->label('Unidad organizativa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_hours_day')
                    ->label('Horas diurnas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_hours_night')
                    ->label('Horas nocturnas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('establishment.alias')
                    ->label('Establecimiento')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf') 
                    ->label('Ver')
                    ->color('success')
                    ->icon('heroicon-o-document')
                    ->url(fn (OvertimeRefund $record) => route('rrhh.overtime-refunds.show', $record))
                    ->openUrlInNewTab(),
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
            'index'  => Pages\ListOvertimeRefunds::route('/'),
            'create' => Pages\CreateOvertimeRefund::route('/create'),
            'edit'   => Pages\EditOvertimeRefund::route('/{record}/edit'),
        ];
    }
}