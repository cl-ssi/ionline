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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

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
                            ->columnSpanFull()
                            ->disabledOn('edit'),
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
                            ->columnSpan(2)
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('ir_al_programa')
                                    ->label('Ir al programa')
                                    ->icon('bi-link')
                                    ->action(fn(Get $get) => redirect()->to(ProgramResource::getUrl('edit', ['record' => $get('program_id')])))
                            ),

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
                            ->columnSpan(2)
                            ->visibleOn('create'),

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
                                    // ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                    //     // Obtiene el monto total
                                    //     $totalAmount = $get('total_amount');
                                    //     dd($totalAmount);
                                        
                                    //     // Valida si totalAmount y el porcentaje son valores numéricos
                                    //     if (is_numeric($totalAmount) && is_numeric($state)) {
                                    //         // Calcula el monto con el porcentaje
                                    //         $amount = ($totalAmount * $state) / 100;
                                    //         $set('amount', round($amount, 2)); // Redondear a 2 decimales
                                    //     }
                                    // }),
                                Forms\Components\TextInput::make('amount')
                                    ->label('Monto')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(2)
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('calculateAmount')
                                            ->label('Calcular valor cuota')
                                            ->icon('heroicon-m-calculator')
                                            ->action(function (Set $set, Get $get, $livewire, $state) {
                                                $total_amount = $get('../../total_amount');
                                                $percentage = $get('percentage');
                                                $amount = ($total_amount * $percentage) / 100;
                                                $set('amount', $amount);
                                            })
                                    ),
                            ])
                            ->defaultItems(0)
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
                    ->visibleOn('edit')
                    ->hidden(fn (?Process $record) => $record === null),

                Forms\Components\Section::make('Documento')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('CrearDocumento')
                            ->label('Crear documento del proceso')
                            ->icon('heroicon-m-document')
                            ->requiresConfirmation()
                            ->action(function (Process $record, Set $set) {
                                $set('document_content', $record->processType->template->parseTemplate($record));
                            })
                            ->disabled(fn(?Process $record) => $record->status === Status::Finished),
                    ])
                    ->footerActions([
                        Forms\Components\Actions\Action::make('guardar_cambios')
                            ->icon('bi-save')
                            ->action('save'),
                        Forms\Components\Actions\Action::make('Finalizar')
                            ->icon('heroicon-m-check')
                            ->requiresConfirmation()
                            ->action(function (Process $record) {
                               $record->update(['status' => Status::Finished]);
                            })
                            ->hidden(fn (?Process $record) => $record->status === Status::Finished),
                        Forms\Components\Actions\Action::make('Volver a editar')
                            ->icon('heroicon-m-pencil-square')
                            ->requiresConfirmation()
                            ->modalDescription('Atención, si el documento ya está visado, deberá volver a visarse.')
                            ->action(function (Process $record) {
                               $record->update(['status' => Status::Draft]);
                               $record->resetEndorsesStatus();
                               $record->createComment('El proceso ha vuelto a estado de borrador, si existían visaciones, fueron reseteadas.');
                            })
                            ->hidden(fn (?Process $record) => $record->status === Status::Draft),
                    ])
                    ->footerActionsAlignment(Alignment::End)
                    ->schema([
                        TinyEditor::make('content')::make('document_content')
                            ->hiddenLabel()
                            ->profile('ionline')
                            ->disabled(fn(?Process $record) => $record->status === Status::Finished),
                        Forms\Components\Textarea::make('distribution')
                            ->label('Distribución')
                            ->helperText('Sólo para resoluciones'),
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
                                // $record->createApprovals($data['referer_id']);
                                Notifications\Notification::make()
                                    ->title('Solicitud de revisión enviada (sin implementar aún)')
                                    ->success()
                                    ->send();
                            }),
                    ])
                    ->schema([
                        Forms\Components\Fieldset::make('Jurídico')
                            ->schema([
                                Forms\Components\DatePicker::make('revision_by_lawyer_at')
                                    ->label('Fecha de revisión'),
                                Forms\Components\Placeholder::make('Revisado por')
                                    ->content(fn(?Process $record) => $record->revisionByLawyerUser?->full_name),
                            ])
                            ->columnSpan(1)
                            ->columns(2),
                        Forms\Components\Fieldset::make('Comuna')
                            ->schema([
                                Forms\Components\DatePicker::make('revision_by_commune_at')
                                    ->label('Fecha de revisión'),
                                Forms\Components\Placeholder::make('Revisado por')
                                ->content(fn(?Process $record) => $record->revisionByCommuneUser?->full_name),
                            ])
                            ->columnSpan(1)
                            ->columns(2)
                            ->visible(fn (?Process $record) => $record->processType->bilateral),

                    ])
                    ->columns(2)
                    ->hiddenOn('create'),

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
                                $record->createEndorses($data['referer_id']);
                                Notifications\Notification::make()
                                    ->title('Visado solicitado')
                                    ->success()
                                    ->send();
                            })
                            ->disabled(fn(?Process $record) => $record->endorses->isNotEmpty() ),
                    ])
                    ->schema([
                        Forms\Components\Repeater::make('endorses')
                            ->relationship()
                            ->addActionLabel('Agregar visación')
                            ->hiddenLabel()
                            // ->addable(false)
                            ->simple(
                                Forms\Components\TextInput::make('initials')
                                    ->label('Nombre')
                                    ->disabled()
                                    ->suffixIcon('heroicon-m-check-circle')
                                    ->suffixIconColor(fn ($record) => match ($record['status'] ?? null) {
                                        true    => 'success',
                                        false   => 'danger',
                                        default => 'gray',
                                    }),
                            )
                            ->columnSpanFull()
                            ->grid(7),

                    ])
                    ->hiddenOn('create')
                    ->columnSpanFull(),

                Forms\Components\Section::make('Comuna')
                    ->schema([
                        Forms\Components\DatePicker::make('sended_to_commune_at')
                            ->label('Fecha de envío a la comuna'),
                        Forms\Components\Fieldset::make('Devolución de la comuna')
                            ->schema([
                                Forms\Components\DatePicker::make('returned_from_commune_at')
                                    ->label('Fecha de devolución')
                                    ->columnSpanFull(),
                                /**
                                 * Ejemplo completo de uso de relación file
                                 */
                                Forms\Components\Group::make()
                                    ->relationship('signedCommuneFile') // Nombre de la relación que está con MorphOne
                                    ->schema([
                                        Forms\Components\FileUpload::make('storage_path') // Ruta donde quedará almacenado el archivo
                                            ->label('Archivo firmado por comuna')
                                            ->directory('ionline/documents/agreements/signed-commune-files')
                                            ->storeFileNamesIn('name')
                                            ->acceptedFileTypes(['application/pdf']),
                                        Forms\Components\Hidden::make('type') // Campo oculto para almacenar el tipo de archivo dentro del modelo File
                                            ->default('signed_commune_file')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                                /* Fin del uso de relacion MorphOne de File */
                                
                            ])
                            ->columnSpan(1),
                    ])
                    ->footerActions([
                        Forms\Components\Actions\Action::make('guardar_cambios')
                            ->icon('bi-save')
                            ->action('save'),
                    ])
                    ->footerActionsAlignment(Alignment::End)
                    ->columns(2)
                    ->hiddenOn('create')
                    ->columnSpanFull()
                    ->visible(fn (?Process $record) => $record->processType->bilateral),

                Forms\Components\Section::make('Firma Director')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('SolicitarFirmaDirector')
                            ->label('Solicitar Firma Director/a')
                            ->icon('heroicon-m-check-circle')
                            ->requiresConfirmation()
                            ->action(function (Process $record, array $data): void {
                                $record->createApproval();
                                Notifications\Notification::make()
                                    ->title('Solicitud de firma a dirección')
                                    ->success()
                                    ->send();
                            }),
                    ])
                    ->schema([
                        Forms\Components\Select::make('signer_id')
                            ->label('Firmante')
                            ->options(
                                Signer::with('user')->get()->pluck('user.full_name', 'id')
                            )
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\Group::make()
                            ->relationship('signer')
                            ->schema([
                                Forms\Components\TextInput::make('appellative')
                                    ->label('Nombre')
                                    ->disabled()
                                    ->suffixIcon('heroicon-m-check-circle')
                                    ->suffixIconColor(fn ($record) => match ($record['status']) {
                                        true    => 'success',
                                        false   => 'danger',
                                        default => 'gray',
                                    }),
                            ]),
                    ])
                    ->columns(7)
                    ->hiddenOn('create'),

                Forms\Components\Section::make('Final del proceso')
                    ->description('Debe subir el documento firmado por el director a Doc Digital para la numeración y distribución, luego completar los campos de número y fecha del proceso y subir el documento firmado. IMPORTANTE: El proceso no se dará por terminado si no estan completos estos campos.')
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label('Número del proceso')
                            ->numeric(),
                        Forms\Components\DatePicker::make('date')
                            ->label('Fecha del proceso'),

                        Forms\Components\Group::make()
                            ->relationship('finalProcessFile')
                            ->schema([
                                Forms\Components\FileUpload::make('storage_path')
                                    ->label('Proceso firmado')
                                    ->directory('ionline/documents/agreements/signed-process-files')
                                    ->storeFileNamesIn('name')
                                    ->acceptedFileTypes(['application/pdf']),
                                Forms\Components\Hidden::make('type')
                                    ->default('final_process_file')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(3),
                    ])
                    ->columns(5)
                    ->hiddenOn('create'),

                Forms\Components\Section::make('Siguiente Proceso')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('Crear proceso dependiente')
                            ->icon('heroicon-m-plus-circle')
                            ->requiresConfirmation()
                            ->action(function (Process $record): void {
                                $record->createNextProcess();
                                Notifications\Notification::make()
                                    ->title('Proceso dependiente creado')
                                    ->success()
                                    ->send();
                            })
                            ->hidden(fn(?Process $record): bool => (bool) $record->next_process_id),
                        Forms\Components\Actions\Action::make('Ir al siguiente proceso')
                            ->label('Ir al proceso')
                            ->icon('heroicon-m-arrow-right')
                            ->url(fn(?Process $record) => ProcessResource::getUrl('edit', ['record' => $record->next_process_id]))
                            ->hidden(fn(?Process $record): bool => !(bool) $record->next_process_id),
                    ])
                    ->schema([
                        Forms\Components\Placeholder::make('childProcessType.name')
                            ->content(fn(?Process $record) => $record->processType->childProcessType?->name)
                            ->label('Nombre del proceso'),

                    ])
                    ->columns(2)
                    ->visible(fn (?Process $record) => $record->processType->has_resolution)
                    ->hiddenOn('create')
                    ->columnSpanFull(),

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
                    ->wrap()
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
                    // ->numeric()
                    ->sortable()
                    ->searchable()
                    ->hiddenOn(ProcessesRelationManager::class),
                Tables\Columns\TextColumn::make('commune.name')
                    ->label('Comuna')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('endorses.avatar')
                    ->label('Visaciones')
                    ->circular()
                    ->stacked(),
                Tables\Columns\ImageColumn::make('approval.avatar')
                    ->label('Firma Director')
                    ->circular()
                    ->sortable(),
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
