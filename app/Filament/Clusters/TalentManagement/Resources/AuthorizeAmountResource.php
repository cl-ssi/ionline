<?php

namespace App\Filament\Clusters\TalentManagement\Resources;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource\Pages;
use App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource\RelationManagers;
use App\Models\IdentifyNeeds\AuthorizeAmount;
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

class AuthorizeAmountResource extends Resource
{
    protected static ?string $model = AuthorizeAmount::class;

    protected static ?string $modelLabel = 'Montos Autorizados';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = TalentManagement::class;

    protected static ?string $navigationGroup = 'DNC';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Formulario de Necesidades de Capacitaciones')
                    ->schema([
                        Grid::make(12)->schema([
                            Forms\Components\TextInput::make('identify_need_id')
                                ->label('ID DNC')
                                ->suffixAction(
                                    Action::make('descargar')
                                        ->icon('heroicon-o-information-circle')
                                        // ->url('https://www.saludtarapaca.gob.cl/wp-content/uploads/2024/01/REX-N%C2%B0-5.181-DICCIONARIO-DE-COMPETENCIAS.pdf')
                                        ->url(fn ($record) => route('filament.intranet.talent-management.resources.identify-needs.edit', $record->identify_need_id))
                                        ->openUrlInNewTab() // Esto abre el enlace en una nueva pestaña
                                )
                                ->disabled()
                                ->columnSpan(6),
                            Forms\Components\Select::make('status')
                                ->label('Ley N°')
                                ->options([
                                    'pending'   => 'Pendiente',
                                    'waitlist'  => 'Lista de Espera',
                                    'accepted'  => 'Aceptada',
                                    'rejected'  => 'Rechazada',
                                ])
                                ->preload()
                                ->columnSpan(6)
                                ->disabled()
                                ->required()
                                ->dehydrated(),
                            Forms\Components\TextInput::make('subject')
                                ->label('Nombre de la actividad')
                                ->afterStateHydrated(function (callable $set, $record) {
                                    if ($record && $record->identifyNeed) {
                                        $set('subject', $record->identifyNeed->subject);
                                    }
                                })
                                ->disabled()
                                ->columnSpan(12),
                            Forms\Components\TextInput::make('strategic_axis')
                                ->label('Objetivo Estrategico')
                                ->afterStateHydrated(function (callable $set, $record) {
                                    if ($record && $record->identifyNeed) {
                                        $set('strategic_axis', $record->identifyNeed->strategicAxis->name);
                                    }
                                })
                                ->disabled()
                                ->columnSpan(6),
                            Forms\Components\TextInput::make('impact_objective')
                                ->label('Objetivo de Impacto')
                                ->afterStateHydrated(function (callable $set, $record) {
                                    if ($record && $record->identifyNeed) {
                                        $set('impact_objective', $record->identifyNeed->impactObjective->description);
                                    }
                                })
                                ->disabled()
                                ->columnSpan(6),
                            Forms\Components\TextInput::make('authorize_amount')
                                ->label('Monto Autorizado')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(6)
                                ->disabled(fn ($record) => $record->authorize_amount != null)
                                ->required(),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identifyNeed.id')
                    ->label('ID DNC')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(fn ($record) => $record->status_value)
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente'         => 'info',
                        'Lista de Espera'   => 'warning',
                        'Aceptada'          => 'success',
                        'Rechazada'         => 'danger',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('identifyNeed.subject')
                    ->label('Nombre de la actividad')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('identifyNeed.strategicAxis.name')
                    ->label('Objetivo Estrategico')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('identifyNeed.impactObjective.description')
                    ->label('Objetivo de Impacto')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('identifyNeed.availablePlaces.estament.name')
                    ->label('Estamentos asociados a la actividad')
                    ->sortable()
                    ->searchable()
                    ->bulleted(),
                Tables\Columns\TextColumn::make('identifyNeed.availablePlaces.places_number')
                    ->label('Cupos asociados a la actividad')
                    ->sortable()
                    ->searchable()
                    ->bulleted(),
                Tables\Columns\TextColumn::make('identifyNeed.nature_of_the_need_value')
                    ->label('Naturaleza de la Necesidad')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('identifyNeed.total_hours')
                    ->label('Horas asociadas')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('identifyNeed.mechanism_value')
                    ->label('Modalidad')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('identifyNeed.total_value')
                    ->label('Presupuesto solicitado')
                    ->getStateUsing(fn ($record) => '$'.number_format($record->identifyNeed->total_value, 0, ',', '.') . ' CLP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('authorize_mount')
                    ->label('Monto Autorizado')
                    ->getStateUsing(fn ($record) => $record->authorize_amount ? '$'.number_format($record->authorize_amount, 0, ',', '.') . ' CLP' : 'Monto no ingresado')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListAuthorizeAmounts::route('/'),
            'create' => Pages\CreateAuthorizeAmount::route('/create'),
            'edit' => Pages\EditAuthorizeAmount::route('/{record}/edit'),
        ];
    }
}
