<?php

namespace App\Filament\Clusters\Rrhh\Resources\Rrhh;

use App\Filament\Clusters\Rrhh;
use App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource\Pages;
use App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource\RelationManagers;
use App\Models\Rrhh\Absenteeism;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Pages\SubNavigationPosition;
use App\Models\AbsenteeismType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Livewire\wrap;

class AbsenteeismResource extends Resource
{
    protected static ?string $model = Absenteeism::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-minus';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $modelLabel = 'ausentismo';

    protected static ?string $pluralLabel = 'ausentismos';

    protected static ?string $cluster = Rrhh::class;

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('absenteeism_type_id')
                    ->label('Tipo de Ausentismo')
                    ->options(function () {
                        return \App\Models\Rrhh\AbsenteeismType::pluck('name', 'id');
                    })
                    ->searchable()
                    ->placeholder('Selecciona un tipo')
                    ->required(),
                Forms\Components\DatePicker::make('finicio')
                    ->label('Fecha Inicio')
                    ->required(),
                Forms\Components\DatePicker::make('ftermino')
                    ->label('Fecha Termino')
                    ->required(),
                Forms\Components\Select::make('jornada')
                    ->label('Jornada')
                    ->options([
                        'AM' => 'AM',
                        'PM' => 'PM',
                        'TO' => 'TODO EL DÍA',
                    ])
                    ->placeholder('Seleccione una jornada')
                    ->helperText('Sólo para permisos administrativos.'),
                Forms\Components\Textarea::make('observacion')
                    ->label('Fundamento')
                    ->rows(1)
                    ->helperText(
                        str('La solicitud será enviada para su aprobación a: <strong>' . auth()->user()->boss->shortName . '</strong><br> 
                            <strong>Importante:</strong> Si no corresponde a su jefatura, primero solicite la corrección con la secretaria de su departamento 
                            antes de crear el permiso.')->toHtmlString()
                    )
                    ->placeholder('Escriba el fundamento aquí...')
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->required(),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('finicio')
                    ->label('Fecha Inicio')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ftermino')
                    ->label('Fecha Termino')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_de_ausentismo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('approval.avatar')
                    ->label('Aprobación')
                    ->circular()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approval.statusInWords')
                    ->label('Estado')
                    ->sortable(),
                ToggleColumn::make('sirh_at')
                    ->label('Sirh')
                    ->onColor('success')
                    ->offColor('gray')
                    ->onIcon('heroicon-s-check-circle')
                    ->offIcon('heroicon-s-x-circle')
                    ->updateStateUsing(function ($state, $record) {
                        $record->update([
                            'sirh_at' => $state ? now() : null,
                        ]);

                    })
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated(false)

            ->filters(
                [
                    Tables\Filters\SelectFilter::make('tipo_de_ausentismo')
                        ->label('Tipo de Ausentismo')
                        ->options(
                            fn() => \App\Models\Rrhh\AbsenteeismType::query()
                                ->pluck('name', 'name')
                                ->toArray()
                        ),
                    Tables\Filters\TernaryFilter::make('aprobaciones')
                        ->label('Aprobaciones')
                        ->placeholder('Todas')
                        ->trueLabel('Con aprobacion')
                        ->falseLabel('Sin  aprobacion')
                        ->queries(
                            true: fn(Builder $query) => $query->whereHas('approval'),
                            false: fn(Builder $query) => $query->whereDoesntHave('approval'),
                            blank: fn(Builder $query) => $query,
                        ),

                    // Tables\Filters\SelectFilter::make('estado_aprobacion')
                    //     ->label('Estado de Aprobación')
                    //     ->options([
                    //         'pendiente' => 'Pendiente',
                    //         'aprobado' => 'Aprobado',
                    //         'rechazado' => 'Rechazado',
                    //     ])
                    //     ->query(function (Builder $query, $state) {
                    //         return $query->whereHas('approval', function ($query) use ($state) {
                    //             $query->where('approvable_type', 'App\\Models\\Rrhh\\Absenteeism')
                    //                 ->whereNull('sign_approvals.deleted_at'); // Aseguramos que la aprobación no esté eliminada
                
                    //             if ($state === 'pendiente') {
                    //                 $query->whereNull('approval.status'); // Estado pendiente
                    //             } elseif ($state === 'aprobado') {
                    //                 $query->where('approval.status', 1); // Estado aprobado
                    //             } elseif ($state === 'rechazado') {
                    //                 $query->where('approval.status', 0); // Estado rechazado
                    //             }
                    //         });
                    //     }),


                    // Verificar el Funcionamiento del Filtro


                    // Tables\Filters\TernaryFilter::make('estado_aprobacion')
                    //     ->label('Estado de aprobaciones')
                    //     ->placeholder('Pendiente')
                    //     ->trueLabel('Aprobada')
                    //     ->falseLabel('Rechazada')
                    //     ->queries(
                    //         true: fn(Builder $query) => $query->whereRelation('approval' , 'status', true),
                    //         false: fn(Builder $query) => $query->whereRelation('approval' , 'status', false),
                    //         blank: fn(Builder $query) => $query->whereRelation('approval' , 'status', '=', null),
                    //     ),

                ],

                layout: FiltersLayout::AboveContent
            )

            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn(Absenteeism $record) => route('rrhh.absenteeisms.show', $record))
                    ->openUrlInNewTab()
                    ->visible(fn(Absenteeism $record) => $record->approval && $record->approval->status == 1),

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
            'index' => Pages\ListAbsenteeisms::route('/'),
            'create' => Pages\CreateAbsenteeism::route('/create'),
            'edit' => Pages\EditAbsenteeism::route('/{record}/edit'),
        ];
    }
}
