<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Enums\Documents\Agreements\Status;
use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Pages;
use App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers\ProcessesRelationManager;
use App\Models\Documents\Agreements\Process;
use App\Models\Documents\Agreements\Signer;
use App\Models\Documents\Document;
use App\Models\Establishment;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProcessResource extends Resource
{
    protected static ?string $model = Process::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $modelLabel = 'proceso';

    protected static ?string $pluralModelLabel = 'procesos';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('process_type_id')
                    ->label('Tipo de proceso')
                    ->relationship('processType', 'name')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('period')
                    ->label('Periodo')
                    ->required()
                    ->live()
                    ->options(function () {
                        $currentYear = now()->addYear()->year;
                        $years       = [];
                        for ($i = 0; $i < 6; $i++) {
                            $years[$currentYear - $i] = $currentYear - $i;
                        }

                        return $years;
                    })
                    ->default(now()->year)
                    ->hiddenOn(ProcessesRelationManager::class),
                Forms\Components\Select::make('program_id')
                    ->label('Programa')
                    ->relationship('program', 'name', fn (Builder $query, callable $get) => $query->where('period', $get('period')))
                    ->hiddenOn(ProcessesRelationManager::class)
                    ->required()
                    ->columnSpan(2),

                Forms\Components\Select::make('commune_id')
                    ->label('Comuna')
                    ->relationship('commune', 'name')
                    ->required()
                    ->searchable()
                    ->live(),
                Forms\Components\Select::make('municipality_id')
                    ->label('Municipalidad')
                    ->relationship(
                        name: 'municipality',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, Get $get): Builder => $query->where('commune_id', $get('commune_id'))
                    )
                    ->required()
                    ->live(),
                // Forms\Components\TextInput::make('municipality_name')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('municipality_rut')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('municipality_adress')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\Select::make('mayor_id')
                    ->label('Alcalde')
                    ->relationship(
                        name: 'mayor',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, Get $get): Builder => $query->where('municipality_id', $get('municipality_id'))
                    )
                    ->required(),
                // Forms\Components\TextInput::make('mayor_name')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('mayor_run')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('mayor_appelative')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('mayor_decree')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\TextInput::make('total_amount')
                    ->label('Monto total')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('number')
                    ->label('Número')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('date')
                    ->label('Fecha'),
                Forms\Components\Select::make('establishments')
                    ->label('Establecimientos')
                    ->multiple()
                    ->columnSpanFull()
                    ->options(
                        options: fn (Get $get): Collection => Establishment::where('cl_commune_id', $get('commune_id'))->pluck('name', 'id')
                    ),
                Forms\Components\TextInput::make('quotas')
                    ->label('Cuotas')
                    ->numeric()
                    ->default(null)
                    ->helperText('Solo para programa de anticipo de aporte estatal'),
                Forms\Components\Select::make('signer_id')
                    ->label('Firmante')
                    ->options(
                        Signer::with('user')->get()->pluck('user.full_name', 'id')
                    )
                    ->required(),
                // Forms\Components\TextInput::make('signer_appellative')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\Textarea::make('signer_decree')
                //     ->required()
                //     ->columnSpanFull(),
                // Forms\Components\TextInput::make('signer_name')
                //     ->required()
                //     ->maxLength(255),

                Forms\Components\Select::make('next_process_id')
                    ->label('Siguiente proceso')
                    ->relationship('nextProcess', 'id')
                    ->default(null),

                Forms\Components\ToggleButtons::make('status')
                    ->inline()
                    ->options(Status::class)
                    ->columnSpanFull(),

                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('CrearDocumento')
                        ->label('Crear documento del proceso')
                        ->icon('heroicon-m-document')
                        // ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Process $record) {
                            $record->createOrUpdateDocument();
                            Notifications\Notification::make()
                                ->title('Documento creado')
                                ->success()
                                ->actions([
                                    Notifications\Actions\Action::make('Ver')
                                        ->button()
                                        ->url(route('documents.show', $record->document_id), shouldOpenInNewTab: true),
                                    Notifications\Actions\Action::make('Editar')
                                        ->button()
                                        ->url(route('documents.edit', $record->document_id), shouldOpenInNewTab: true),
                                ])
                                ->send();
                        }),
                        // ->hidden(fn (Process $record) => $record->document_id == null),
                    Forms\Components\Actions\Action::make('EliminarDocumento')
                        ->label('Eliminar documento del proceso')
                        ->icon('heroicon-m-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Process $record) {
                            if ($record->document_id) {
                                $document = Document::find($record->document_id);
                                if ($document) {
                                    $document->delete();
                                    $record->document_id = null;
                                    $record->save();
                                    Notifications\Notification::make()
                                        ->title('Documento eliminado')
                                        ->success()
                                        ->send();
                                }
                            }
                        }),
                        // ->hidden(fn (Process $record) => $record->document_id === null),
                    Forms\Components\Actions\Action::make('SolicitarVisado')
                        ->icon('heroicon-m-check-circle')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('referer_id')
                                ->label('Referente')
                                ->options(fn (Process $record) => $record->program->referers->pluck('full_name', 'id'))
                                ->required(),
                        ])
                        ->action(function (Process $record, array $data): void {
                            $record->createApprovals($data['referer_id']);
                            Notifications\Notification::make()
                                ->title('Visado solicitado')
                                ->success()
                                ->send();
                        }),
                ])
                ->columnSpanFull()
                ->fullWidth(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('processType.name')
                    ->label('Tipo de proceso')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program.name')
                    ->label('Programa')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->hiddenOn(ProcessesRelationManager::class),
                Tables\Columns\TextColumn::make('period')
                    ->label('Periodo')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->hiddenOn(ProcessesRelationManager::class),
                Tables\Columns\TextColumn::make('commune.name')
                    ->label('Comuna')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('approvals.avatar')
                    ->label('Aprobaciones')
                    ->circular()
                    ->stacked(),
                // Tables\Columns\TextColumn::make('total_amount')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('number')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('date')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('quotas')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('signer.id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('signer_appellative')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('signer_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('municipality.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('municipality_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('municipality_rut')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('municipality_adress')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mayor.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('mayor_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mayor_run')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mayor_appelative')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mayor_decree')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('process.id')
                //     ->numeric()
                //     ->sortable(),
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
                Tables\Filters\SelectFilter::make('Tipo de proceso')
                    ->relationship('processType', 'name'),
                // Tables\Filters\SelectFilter::make('programa')
                //     ->relationship(
                //         name: 'program',
                //         titleAttribute: 'name',
                //         modifyQueryUsing: fn (Builder $query):
                //             Builder => $query->where('period', 2024)
                //     ),
                Tables\Filters\SelectFilter::make('comuna')
                    ->relationship(
                        name: 'commune',
                        titleAttribute: 'name',
                    )
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Process $record) => route('documents.agreements.processes.view', [$record]))
                    ->openUrlInNewTab(),
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
            'index'  => Pages\ListProcesses::route('/'),
            'create' => Pages\CreateProcess::route('/create'),
            'edit'   => Pages\EditProcess::route('/{record}/edit'),
        ];
    }
}
