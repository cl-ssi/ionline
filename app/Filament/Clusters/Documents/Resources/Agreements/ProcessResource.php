<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Enums\Documents\Agreements\Status;
use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Pages;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Widgets;
use App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers\ProcessesRelationManager;
use App\Filament\RelationManagers\CommentsRelationManager;
use App\Models\Comment;
use App\Models\Documents\Agreements\Process;
use App\Models\Documents\Agreements\Signer;
use App\Models\Documents\Document;
use App\Models\Establishment;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
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
                // Forms\Components\ToggleButtons::make('status')
                //     ->label('Estado')
                //     ->inline()
                //     ->options(Status::class)
                //     ->columnSpanFull()
                //     ->disabled(),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('process_type_id')
                            ->label('Tipo de proceso')
                            ->relationship('processType', 'name', fn (Builder $query) => $query->where('is_dependent', false))
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
                            ->relationship('program', 'name', fn (Builder $query, callable $get) => $query->where('is_program', true)->where('period', $get('period')))
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
                        Forms\Components\Select::make('mayor_id')
                            ->label('Alcalde')
                            ->relationship(
                                name: 'mayor',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query, Get $get): Builder => $query->where('municipality_id', $get('municipality_id'))
                            )
                            ->required(),
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Monto total')
                            ->numeric()
                            ->default(null),
                        Forms\Components\TextInput::make('quotas_qty')
                            ->label('Cuotas')
                            ->numeric()
                            ->default(null)
                            ->helperText('Solo para programa de anticipo de aporte estatal'),
                        Forms\Components\Select::make('establishments')
                            ->label('Establecimientos')
                            ->multiple()
                            ->columnSpanFull()
                            ->options(
                                options: fn (Get $get): Collection => Establishment::where('cl_commune_id', $get('commune_id'))->pluck('name', 'id')
                            ),
                        Forms\Components\Select::make('signer_id')
                            ->label('Firmante')
                            ->options(
                                Signer::with('user')->get()->pluck('user.full_name', 'id')
                            )
                            ->required()
                            ->columnSpan(2),

                        // Forms\Components\Select::make('next_process_id')
                        //     ->label('Siguiente proceso')
                        //     ->relationship('nextProcess', 'id')
                        //     ->default(null),

                        Forms\Components\Repeater::make('quotas')
                            ->label('Cuotas')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('description')
                                    ->label('Descripción')
                                    ->required()
                                    ->columnSpan(3),
                                Forms\Components\TextInput::make('percentage')
                                    ->label('Porcentaje')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('amount')
                                    ->label('Monto')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(2),
                            ])
                            ->columns(6)
                            ->columnSpanFull(),

                    ])
                    ->columns(3)
                    ->columnSpan(3),

                Forms\Components\Section::make('Últimos Comentarios')
                    ->schema([
                        Forms\Components\Repeater::make('comments')
                            ->hiddenLabel()
                            ->relationship()
                            ->reorderable(false)
                            ->deletable(false)
                            ->addable(false)
                            ->schema([
                                Forms\Components\Placeholder::make('body')
                                    ->hiddenLabel()
                                    ->content(fn (Comment $record): string => $record->body)
                                    ->helperText(fn (Comment $record): string => $record->author->shortName.' '.$record->created_at->diffForHumans()),
                            ])
                            // ->live(true)
                            // ->columns(2)
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Process $record) => $record === null),
                        // Forms\Components\TextInput::make('nuevoComentario')
                        //     ->hintAction(
                        //         Forms\Components\Actions\Action::make('agregar')
                        //             ->icon('heroicon-m-plus-circle')
                        //             // ->requiresConfirmation()
                        //             ->action(function (Process $record, $state, $livewire) {
                        //                 $record->comments()->create([
                        //                     'body' => $state,
                        //                 ]);
                        //                 // $record->load('comments');
                        //                 // $livewire->form->fill($livewire->form->getState());
                        //                 // // Limpiar el campo de entrada $livewire->form->getState()
                        //                 // $livewire->form->fill(['nuevoComentario' => '']);
                        //                 // $livewire->form->fill($livewire->form->getState());
                        //             })
                        //     ),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Process $record) => $record === null),

                Forms\Components\Section::make('Documento')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('CrearDocumento')
                            ->label('Crear documento del proceso')
                            ->icon('heroicon-m-document')
                            ->requiresConfirmation()
                            ->action(function (Process $record, Set $set) {
                                $set('document_content', $record->processType->template->parseTemplate($record));
                            }),
                    ])
                    ->footerActions([
                        Forms\Components\Actions\Action::make('Finalizar')
                            // ->label('Crear documento del proceso')
                            ->icon('heroicon-m-check')
                            ->requiresConfirmation()
                            ->action(function (Process $record, Set $set) {
                                $set('document_content', $record->processType->template->parseTemplate($record));
                            }),
                    ])
                    ->footerActionsAlignment(Alignment::End)
                    ->schema([
                        Forms\Components\RichEditor::make('document_content')
                            ->hiddenLabel(),
                        Forms\Components\Textarea::make('distribution')
                            ->label('Distribución')
                            ->required(),
                    ])
                    ->hiddenOn('create'),
                // ->hidden(fn (?Process $record) => $record->document_content === null)

                Forms\Components\Section::make('Revisiones')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('Solicitar Revisión')
                            ->label('Solicitar Revisión')
                            ->icon('heroicon-m-check-circle')
                            ->requiresConfirmation()
                            ->action(function (Process $record, array $data): void {
                                $record->createApprovals($data['referer_id']);
                                Notifications\Notification::make()
                                    ->title('Visado solicitado')
                                    ->success()
                                    ->send();
                            }),
                    ])
                    ->schema([
                        Forms\Components\Fieldset::make('Jurídico')	
                            ->schema([
                                Forms\Components\DatePicker::make('date')
                                    ->label('Fecha de revisión'),
                                Forms\Components\Placeholder::make('Estado')
                                    ->content('Pendiente')
                            ])
                            ->columnSpan(1)
                            ->columns(1),
                        Forms\Components\Fieldset::make('Comuna')	
                            ->schema([
                                Forms\Components\DatePicker::make('date')
                                    ->label('Fecha de revisión'),
                                Forms\Components\Placeholder::make('Estado')
                                    ->content('Pendiente')
                            ])
                            ->columnSpan(1)
                            ->columns(1),

                    ])
                    ->columns(2)
                    ->hiddenOn('create'),

                Forms\Components\Split::make([
                    Forms\Components\Section::make('Visaciones')
                        ->headerActions([
                            Forms\Components\Actions\Action::make('SolicitarVisado')
                                ->label('Solicitar visado')
                                ->icon('heroicon-m-check-circle')
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
                        ->schema([
                            Forms\Components\Repeater::make('approvals')
                                ->relationship()
                                ->hiddenLabel()
                                ->addable(false)
                                ->simple(
                                    Forms\Components\TextInput::make('initials')
                                        ->label('Nombre')
                                        ->required()
                                        ->suffixIcon('heroicon-m-check-circle')
                                        ->suffixIconColor(fn ($record) => match ($record['status']) {
                                            true    => 'success',
                                            false   => 'danger',
                                            default => 'gray',
                                        }),
                                )
                                ->columns(3)
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Section::make('Comuna')
                        ->schema([
                            Forms\Components\DateTimePicker::make('sended_at')
                                ->label('Fecha de envío a la comuna'),
                            Forms\Components\Fieldset::make('Devolución de la comuna')
                                ->schema([
                                    Forms\Components\DateTimePicker::make('received_at')
                                        ->label('Fecha de devolución')
                                        ->columnSpanFull(),
                                    Forms\Components\FileUpload::make('attachment')
                                        ->label('Proceso firmado')
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ])
                ->hiddenOn('create')
                ->columnSpanFull(),

                Forms\Components\Section::make('Firma Director')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('SolicitarFirmaDirector')
                            ->label('Solicitar Firma Director/a')
                            ->icon('heroicon-m-check-circle')
                            ->requiresConfirmation()
                            ->action(function (Process $record, array $data): void {
                                $record->createApprovals($data['referer_id']);
                                Notifications\Notification::make()
                                    ->title('Visado solicitado')
                                    ->success()
                                    ->send();
                            }),
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('signer.user.full_name')
                            ->label('Nombre')
                            ->required()
                            ->suffixIcon('heroicon-m-check-circle')
                            ->suffixIconColor(fn ($record) => match ($record['status']) {
                                true    => 'success',
                                false   => 'danger',
                                default => 'gray',
                            }),
                        Forms\Components\TextInput::make('number')
                            ->label('Número del proceso')
                            ->numeric()
                            ->default(null),
                        Forms\Components\DatePicker::make('date')
                            ->label('Fecha del proceso'),
                        Forms\Components\FileUpload::make('attachment')
                            ->label('Proceso firmado'),
                    ])
                    ->columns(3)
                    ->hiddenOn('create'),
                // Forms\Components\Select::make('status')
                //     ->label('Estado')
                //     ->options(Status::class),
            ])
            ->columns(4);
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
            CommentsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\StepsChart::class,
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
