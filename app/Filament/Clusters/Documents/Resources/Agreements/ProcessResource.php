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
use App\Models\Documents\Agreements\ProcessType;
use App\Models\Documents\Agreements\Signer;
use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Notifications\Documents\Agreeements\NewProcessCommuneNotification;
use App\Notifications\Documents\Agreeements\NewProcessLegallyNotification;
use App\Notifications\Documents\Agreeements\ProcessCommunePdf;
use App\Services\ColorCleaner;
use App\Services\TableCleaner;
use App\Services\TextCleaner;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
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
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
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

    protected static function isProcessSigned(?Process $record): bool
    {
        return $record?->approval?->status === true;
    }

    public static function form(Form $form): Form
    {
        if (auth()->user()->can('Agreement: legally')) {
            return $form
                ->schema(static::legallyFormSchema())->columns(4);
        } else {
            return $form
                ->schema(static::basicFormSchema())->columns(4);
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->searchable()
                    ->sortable(),
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
                // Tables\Columns\TextColumn::make('establishmentsList')
                //     ->label('Establecimientos')
                //     ->searchable()
                //     ->width('sm')
                //     ->wrap()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('establishmentsList')
                    ->label('Establecimientos')
                    ->getStateUsing(fn (Process $record) => $record->establishmentsList)
                    ->width('sm')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                // Tables\Columns\TextColumn::make('municipality_address')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mayor.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('mayor_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mayor_run')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mayor_appellative')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mayor_decree')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('process.id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\IconColumn::make('finalProcessFile')
                    ->label('Proceso Firmado')
                    ->icon('heroicon-o-document-text')
                    ->color('danger')
                    ->url(function (?Process $record) {
                        if ($record && $record->processType && $record->processType->is_resolution && $record->finalProcessFile) {
                            return Storage::url($record->finalProcessFile->storage_path);
                        }
                        return null;
                    })
                    ->openUrlInNewTab()
                    ,
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
                    ->relationship('processType', 'name',
                        fn (Builder $query) => $query->where('is_certificate', false)->where('active', true))
                    ->label('Tipo de proceso'),

                Tables\Filters\SelectFilter::make('period')
                    ->label('Periodo')
                    ->options(array_combine(range(date('Y'), date('Y') - 5), range(date('Y'), date('Y') - 5))),
                Tables\Filters\SelectFilter::make('program_id')
                    ->label('Programa')
                    /**
                     * No pude hacer el filtro dependiente del año para solo mostrar los programas
                     * del periodo seleccionado arriba, te toca resolver Rojas
                     */
                    ->relationship(
                        name: 'program',
                        titleAttribute: 'name',
                        modifyQueryUsing: // que tengan procesos
                        fn (Builder $query, Get $get): Builder => $query->whereHas('processes'),
                    ),
                Tables\Filters\SelectFilter::make('comuna')
                    ->label('Comuna')
                    ->relationship(
                        name: 'commune',
                        titleAttribute: 'name',
                    )
                    ->searchable(),

                Tables\Filters\TernaryFilter::make('pending_lawyer_review')
                    ->label('Pendiente revisión jurídico')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNull('revision_by_lawyer_at')
                            ->whereNotNull('sended_revision_lawyer_at'),
                        false: fn (Builder $query) => $query->whereNotNull('revision_by_lawyer_at'),
                        blank: fn (Builder $query) => $query
                    )
                    ->default(fn () => auth()->user()->hasRole('Convenios: Jurídico') ? true : null),

                Tables\Filters\TernaryFilter::make('pending_commune_review')
                    ->label('Pendiente revisión comuna')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNull('revision_by_commune_at')
                            ->whereNotNull('sended_revision_commune_at'),
                        false: fn (Builder $query) => $query->whereNotNull('revision_by_commune_at'),
                        blank: fn (Builder $query) => $query
                    ),

                Tables\Filters\TernaryFilter::make('pending_endorses')
                    ->label('Pendiente visaciones')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('sended_endorses_at')
                            ->whereDoesntHave('endorses', function ($query) {
                                $query->where('status', true);
                            }),
                        false: fn (Builder $query) => $query->whereNotNull('sended_endorses_at')
                            ->whereDoesntHave('endorses', function ($query) {
                                $query->where('status', false)->orWhereNull('status');
                            }),
                        blank: fn (Builder $query) => $query
                    ),

                Tables\Filters\TernaryFilter::make('pending_commune_signature')
                    ->label('Pendiente firma comuna')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNull('returned_from_commune_at')
                            ->whereNotNull('sended_to_commune_at'),
                        false: fn (Builder $query) => $query->whereNotNull('returned_from_commune_at'),
                        blank: fn (Builder $query) => $query
                    ),
            ], layout: Tables\Enums\FiltersLayout::AboveContent) // Agregar esta configuración
            ->actions([
                // Tables\Actions\Action::make('Ver')
                //     ->icon('heroicon-m-eye')
                //     ->url(fn (Process $record) => route('documents.agreements.processes.view', [$record]))
                //     ->openUrlInNewTab(),
                Tables\Actions\Action::make('Ver')
                    ->icon('heroicon-m-eye')
                    ->url(function (Process $record) {
                        
                        // Case 1: If the process is fully approved by the director
                        if ($record->approval?->status === true) {
                            return Storage::url($record->approval?->filename ?? '');
                        }

                        // Case 2: If there's a signed file from the commune
                        if ($record->signedCommuneFile && $record->signedCommuneFile->storage_path) {
                            return Storage::url($record->signedCommuneFile->storage_path ?? '');
                            // return $path = $record->signedCommuneFile->storage_path;
                        }
                        
                        // Case 3: Default - show the process view
                        return route('documents.agreements.processes.view', [$record]);
                    })
                    ->openUrlInNewTab()
                    ->color(function (Process $record) {
                        if ($record->approval?->status === true) {
                            return 'success'; // Green for director signed
                        }
                        if ($record->signedCommuneFile) {
                            return 'warning'; // Yellow for commune signed
                        }
                        return 'gray'; // Gray for draft
                    })
                    ->tooltip(function (Process $record) {
                        if ($record->approval?->status === true) {
                            return 'Documento finalizado firmado por director';
                        }
                        if ($record->signedCommuneFile?->exists()) {
                            return 'Documento firmado por comuna';
                        }
                        return 'Documento sin firmas';
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->paginated([25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
            \App\Filament\RelationManagers\AuditsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            // Widgets\StepsChart::class,
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

    protected static function basicFormSchema(): array
    {
        return [
            // Forms\Components\ToggleButtons::make('status')
            //     ->label('Estado')
            //     ->inline()
            //     ->options(Status::class)
            //     ->columnSpanFull()
            //     ->disabled(),

            Forms\Components\Section::make()
                // ->footerActions([
                //     Forms\Components\Actions\Action::make('guardar_cambios')
                //         ->icon('bi-save')
                //         ->action('save'),

                // ])
                // ->footerActionsAlignment(Alignment::End)
                ->schema([
                    Forms\Components\Select::make('process_type_id')
                        ->label('Tipo de proceso')
                        ->relationship('processType', 'name', fn (Builder $query) => $query->where('is_dependent', false)->where('is_certificate', false)->where('active', true))
                        ->required()
                        ->columnSpanFull()
                        ->visibleOn('create'),
                    Forms\Components\Select::make('process_type_id')
                        ->label('Tipo de proceso')
                        ->relationship('processType', 'name')
                        ->required()
                        ->columnSpanFull()
                        ->disabledOn('edit')
                        ->visibleOn('edit'),
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
                        ->disabledOn('edit')
                        ->hiddenOn(ProcessesRelationManager::class),
                    Forms\Components\Select::make('program_id')
                        ->label('Programa')
                        ->relationship('program', 'name', function (Builder $query, callable $get) {
                            $query->where('is_program', true)
                                ->where('period', $get('period'))
                                ->whereHas('referers', function ($query) {
                                    $query->where('user_id', auth()->id());
                                });
                        })
                        ->helperText('Solo programas en los que eres referente')
                        ->hiddenOn(ProcessesRelationManager::class)
                        ->visibleOn('create')
                        ->required()
                        ->disabledOn('edit')
                        ->columnSpan(2)
                        ->suffixAction(
                            Forms\Components\Actions\Action::make('ir_al_programa')
                                ->label('Ir al programa')
                                ->icon('bi-link')
                                ->action(fn (Get $get) => redirect()->to(ProgramResource::getUrl('edit', ['record' => $get('program_id')])))
                        ),
                    Forms\Components\Select::make('program_id')
                        ->label('Programa')
                        ->relationship('program', 'name')
                        ->helperText('Solo programas en los que eres referente')
                        ->hiddenOn(ProcessesRelationManager::class)
                        ->required()
                        ->disabledOn('edit')
                        ->visibleOn('edit')
                        ->columnSpan(2)
                        ->suffixAction(
                            Forms\Components\Actions\Action::make('ir_al_programa')
                                ->label('Ir al programa')
                                ->icon('bi-link')
                                ->action(fn (Get $get) => redirect()->to(ProgramResource::getUrl('edit', ['record' => $get('program_id')])))
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
                        ->required()
                        ->default(null),
                    Forms\Components\TextInput::make('quotas_qty')
                        ->label('Cuotas')
                        ->numeric()
                        ->default(null)
                        ->helperText('Solo para programa de anticipo de aporte estatal y por cuotas'),
                    Forms\Components\DatePicker::make('document_date')
                        ->label('Fecha del documento')
                        ->helperText('Para procesos que llevan fecha en el documento, convenios, adendums, etc.'),
                    Forms\Components\Select::make('establishments')
                        ->label('Establecimientos')
                        ->multiple()
                        ->columnSpanFull()
                        ->options(
                            options: fn (Get $get): Collection => Establishment::where('cl_commune_id', $get('commune_id'))->pluck('official_name', 'id')
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
                                            $percentage   = $get('percentage');
                                            $amount       = ($total_amount * $percentage) / 100;
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
                                ->helperText(fn (Comment $record): string => $record->author?->shortName.' '.$record->created_at->diffForHumans()),
                        ])
                        ->columnSpan(['lg' => 1])
                        ->hidden(fn (?Process $record) => $record === null),
                ])
                ->columnSpan(['lg' => 1])
                ->visibleOn('edit')
                ->hidden(fn (?Process $record) => $record === null),

            Forms\Components\Section::make('Documento')
                ->headerActions([
                    Forms\Components\Actions\Action::make('CopiarDocumento')
                        ->label('Copiar documento de otro proceso')
                        ->icon('heroicon-m-copy')
                        ->modalHeading('Copiar documento de otro proceso')
                        ->modalDescription('Ingrese el ID del proceso del cual desea copiar el contenido del documento. El contenido del documento del proceso actual será completamente reemplazado por el contenido del documento del proceso fuente. Deberá modificar manualmente los campos que necesite.')
                        ->modalButton('Copiar')
                        ->form([
                            Forms\Components\TextInput::make('source_process_id')
                                ->label('ID del proceso fuente')
                                ->numeric()
                                ->required(),
                        ])
                        ->action(function (Process $record, array $data) {
                            $sourceProcess = Process::find($data['source_process_id']);
                            if ($sourceProcess) {
                                $record->update(['document_content' => $sourceProcess->document_content]);
                                Notifications\Notification::make()
                                    ->title('Documento copiado')
                                    ->success()
                                    ->send();
                            } else {
                                Notifications\Notification::make()
                                    ->title('Proceso no encontrado')
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->disabled(fn (?Process $record) => static::isProcessSigned($record)),
                    Forms\Components\Actions\Action::make('CrearDocumento')
                        ->label('Crear documento del proceso')
                        ->icon('heroicon-m-document')
                        ->requiresConfirmation()
                        ->action(function (Process $record, Set $set) {
                            $set('document_content', $record->processType->template->parseTemplate($record));
                        })
                        ->disabled(fn (?Process $record) => 
                            static::isProcessSigned($record) || 
                            $record->status === Status::Finished
                        ),
                ])
                ->footerActions([
                    Forms\Components\Actions\Action::make('guardar_cambios')
                        ->icon('bi-save')
                        ->action(function (Process $record, $livewire) {
                            // Save using the livewire form component
                            $livewire->save();
                            
                            // Redirect to refresh the page
                            return redirect()->to(ProcessResource::getUrl('edit', ['record' => $record->id]));
                        })
                        ->disabled(fn (?Process $record) => static::isProcessSigned($record)),
                    Forms\Components\Actions\Action::make('Finalizar')
                        ->icon('heroicon-m-check')
                        ->requiresConfirmation()
                        ->action(function (Process $record) {
                            $record->update(['status' => Status::Finished]);

                            // Redireccionar a la misma página para forzar recarga
                            return redirect()->to(ProcessResource::getUrl('edit', ['record' => $record->id]));
                        })
                        ->hidden(fn (?Process $record) => $record->status === Status::Finished)
                        ->disabled(fn (?Process $record) => static::isProcessSigned($record)),
                    Forms\Components\Actions\Action::make('Volver a editar')
                        ->icon('heroicon-m-pencil-square')
                        ->requiresConfirmation()
                        // ->modalDescription('Atención, si el documento ya está visado, deberá volver a visarse.')
                        ->action(function (Process $record) {
                            $record->update(['status' => Status::Draft]);
                            // $record->resetEndorsesStatus();
                            // $record->resetLegallyStatus();
                            // $record->createComment('El proceso ha vuelto a estado de borrador, si existían visaciones, fueron reseteadas.');
                            $record->createComment('El proceso ha vuelto a estado de borrador.');

                            // Redireccionar a la misma página para forzar recarga
                            return redirect()->to(ProcessResource::getUrl('edit', ['record' => $record->id]));
                        })
                        ->hidden(fn (?Process $record) => $record->status === Status::Draft)
                        ->disabled(fn (?Process $record) => static::isProcessSigned($record)),
                    Forms\Components\Actions\Action::make('Ver')
                        ->icon('heroicon-m-eye')
                        ->url(fn (Process $record) => route('documents.agreements.processes.view', [$record]))
                        ->openUrlInNewTab(),
                ])
                // ->footerActionsAlignment(Alignment::End)
                ->schema([
                    TinyEditor::make('document_content')
                        ->hiddenLabel()
                        ->maxHeight(1200)
                        ->profile('ionline')
                        ->live(false) // Desactiva la reactividad
                        ->disabled(fn (?Process $record) => 
                            static::isProcessSigned($record) || 
                            $record->status === Status::Finished
                        )
                        ->hintActions(
                            [
                                Forms\Components\Actions\Action::make('limpiarTabla')
                                    ->icon('heroicon-m-clipboard')
                                    ->requiresConfirmation()
                                    ->action(function (Get $get, Set $set) {
                                        $content        = $get('document_content');
                                        $cleanedContent = TableCleaner::clean($content);
                                        $set('document_content', $cleanedContent);
                                    })
                                    ->disabled(fn (?Process $record) => $record->status === Status::Finished),

                                Forms\Components\Actions\Action::make('limpiarTexto')
                                    ->icon('heroicon-m-clipboard')
                                    ->requiresConfirmation()
                                    ->action(function (Get $get, Set $set) {
                                        $content        = $get('document_content');
                                        $cleanedContent = TextCleaner::clean($content);
                                        $set('document_content', $cleanedContent);
                                    })
                                    ->disabled(fn (?Process $record) => $record->status === Status::Finished),

                                Forms\Components\Actions\Action::make('limpiarColor')
                                    ->icon('heroicon-m-clipboard')
                                    ->requiresConfirmation()
                                    ->action(function (Get $get, Set $set) {
                                        $content        = $get('document_content');
                                        $cleanedContent = ColorCleaner::clean($content);
                                        $set('document_content', $cleanedContent);
                                    })
                                    ->disabled(fn (?Process $record) => $record->status === Status::Finished),

                            ]
                        ),
                    // Forms\Components\Textarea::make('distribution')
                    //     ->label('Distribución')
                    //     ->helperText('Sólo para resoluciones')
                ])
                ->hiddenOn('create'),

            Forms\Components\Section::make('Revisión Jurídico')
                ->description(fn (?Process $record) => $record->status === Status::Finished ? '' : 'El botón estará disponible cuando el formato esté finalizado.') 
                ->headerActions([
                    Forms\Components\Actions\Action::make('Solicitar Revisión')
                        ->label('Solicitar revisión jurídico')
                        ->icon('heroicon-m-check-circle')
                        ->requiresConfirmation()
                        ->action(function (Process $record, array $data): void {
                            /**
                             * Notificar a Jurídico de la solicitud de revisión
                             */
                            $recipients = User::permission('Agreement: legally')->get();

                            Notifications\Notification::make()
                                ->title('Solicitud de revisión de proceso N°'. $record->id)
                                ->actions([
                                    Notifications\Actions\Action::make('IrAlProceso')
                                        ->button()
                                        ->url(ProcessResource::getUrl('edit', [$record->id]))
                                        ->markAsRead(),
                                ])
                                ->sendToDatabase($recipients);

                            // También enviar por mail cada persona que tenga el permiso Agreement: legally
                            foreach ($recipients as $recipient) {
                                $recipient->notify(new NewProcessLegallyNotification($record));
                            }

                            Notifications\Notification::make()
                                ->title('Solicitud de revisión N°' . $record->id . ' enviada a jurídico')
                                ->success()
                                ->send();

                            // establecer fecha de solicitud de revisión
                            $record->update(['sended_revision_lawyer_at' => now(), 'sended_revision_lawyer_user_id' => auth()->id()]);

                        })
                        ->disabled(fn (?Process $record) => static::isProcessSigned($record) || $record->revision_by_lawyer_user_id !== null || $record->status != Status::Finished),
                ])
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\DatePicker::make('sended_revision_lawyer_at')
                                ->label('Fecha de solicitud')
                                ->disabled(),
                            Forms\Components\Placeholder::make('Solicitado por')
                                ->content(fn (?Process $record) => $record->lawyerRevisionSenderUser?->shortName ?? 'N/A'),
                            Forms\Components\DatePicker::make('revision_by_lawyer_at')
                                ->label('Fecha de revisión')
                                ->disabled(),
                            Forms\Components\Placeholder::make('Revisado por')
                                ->content(fn (?Process $record) => $record->revisionByLawyerUser?->shortName ?? 'N/A'),
                        ]),
                ])
                ->columnSpan(2)
                ->columns(2)
                ->hiddenOn('create'),

            Forms\Components\Section::make('Revision de Comuna')
                ->description(fn (?Process $record) => $record->status === Status::Finished ? '' : 'El botón estará disponible cuando el formato esté finalizado.') 
                ->headerActions([
                    Forms\Components\Actions\Action::make('Solicitar revisión comuna')
                        ->label('Solicitar Revisión')
                        ->icon('heroicon-m-check-circle')
                        ->requiresConfirmation()
                        ->action(function (Process $record, array $data): void {
                            /**
                             * Notificar a Comunas de la solicitud de revisión
                             */
                            $recipients = $record->municipality->emails;

                            foreach ($recipients as $recipient) {
                                Notification::route('mail', $recipient)->notify(new NewProcessCommuneNotification($record));
                            }

                            Notifications\Notification::make()
                                ->title('Solicitud de revisión enviada a comunas')
                                ->success()
                                ->send();

                            // establecer fecha de solicitud de revisión
                            $record->update(['sended_revision_commune_at' => now(), 'sended_revision_commune_user_id' => auth()->id()]);
                        })
                        ->disabled(fn (?Process $record) => 
                            static::isProcessSigned($record) || 
                            $record->revision_by_commune_user_id !== null || 
                            $record->status != Status::Finished ||
                            $record->endorses->contains(fn ($endorse) => $endorse->status !== true)
                        ),
                ])
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\DatePicker::make('sended_revision_commune_at')
                                ->label('Fecha de solicitud')
                                ->disabled(),
                            Forms\Components\Placeholder::make('Solicitado por')
                                ->content(fn (?Process $record) => $record->communeRevisionSenderUser?->full_name ?? 'N/A'),
                            Forms\Components\DatePicker::make('revision_by_commune_at')
                                ->label('Fecha de revisión'),
                            Forms\Components\Placeholder::make('Revisado por')
                                ->content(fn (?Process $record) => $record->revisionByCommuneUser?->full_name ?? 'N/A'),
                        ]),
                ])
                ->columnSpan(2)
                ->visible(fn (?Process $record) => $record->processType->revision_commune)
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
                            // set the date of the endorsement request
                            $record->update(['sended_endorses_at' => now()]);

                            Notifications\Notification::make()
                                ->title('Visado solicitado')
                                ->success()
                                ->send();

                            redirect(request()->header('Referer')); // Redirige al usuario a la misma página
                        })
                        ->disabled(fn (?Process $record) => $record?->endorses?->isNotEmpty()),
                    Forms\Components\Actions\Action::make('NuevoVisador')
                        ->label('Nuevo visador')
                        ->icon('heroicon-m-plus-circle')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('establishment_id')
                                ->label('Establecimiento')
                                ->options(Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
                                ->default(auth()->user()->establishment_id)
                                ->live(),
                            SelectTree::make('sent_to_ou_id')
                                ->label('Unidad Organizacional')
                                ->relationship(
                                    relationship: 'sentToOu',
                                    titleAttribute: 'name',
                                    parentAttribute: 'organizational_unit_id',
                                    modifyQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name'),
                                    modifyChildQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name')
                                )
                                ->searchable()
                                ->parentNullValue(null)
                                ->enableBranchNode()
                                ->defaultOpenLevel(1)
                                ->live(),
                            Forms\Components\Section::make()
                                ->description('O enviar a un usuario específico')
                                ->schema([
                                    Forms\Components\Select::make('sent_to_user_id')
                                        ->label('Usuario (solo para casos en no sea una jefatura)')
                                        ->searchable()
                                        ->getSearchResultsUsing(function (string $search) {
                                            $terms = explode(' ', $search);
                                            return User::query()
                                                ->where(function ($query) use ($terms) {
                                                    foreach ($terms as $term) {
                                                        $query->where(function ($subQuery) use ($term) {
                                                            $subQuery->where('name', 'like', "%{$term}%")
                                                                ->orWhere('fathers_family', 'like', "%{$term}%")
                                                                ->orWhere('mothers_family', 'like', "%{$term}%")
                                                                ->orWhere('id', 'like', "%{$term}%");
                                                        });
                                                    }
                                                })
                                                ->get()
                                                ->mapWithKeys(fn ($user) => [$user->id => "{$user->name} {$user->fathers_family}"])
                                                ->toArray();
                                        })
                                        ->getOptionLabelUsing(fn ($value) => User::find($value) ? User::find($value)->name . ' ' . User::find($value)->fathers_family . ' ' . User::find($value)->mothers_family : 'N/A')
                                        ->columnSpanFull(),
                                ])
                                ->collapsed()
                                ->compact(),
                        ])
                        ->action(function (Process $record, array $data): void {
                            $record->addNewEndorse($data);
                            Notifications\Notification::make()
                                ->title('Visado solicitado')
                                ->success()
                                ->send();
                            redirect(request()->header('Referer')); // Redirige al usuario a la misma página
                        })
                        ->disabled(fn (?Process $record) => static::isProcessSigned($record)),
                ])
                ->footerActions([
                    // Forms\Components\Actions\Action::make('guardar_cambios')
                    //     ->icon('bi-save')
                    //     ->action('save'),
                    Forms\Components\Actions\Action::make('guardar_cambios')
                        ->icon('bi-save')
                        ->action(function (Process $record, $livewire) {
                            // Get original endorses with names before saving
                            $originalEndorses = $record->endorses->map(function($endorse) {
                                return [
                                    'id' => $endorse->id,
                                    'initials' => $endorse->initials,
                                    'ou_name' => $endorse->sent_to_ou?->name ?? 'N/A'
                                ];
                            })->keyBy('id')->toArray();
                            
                            // Save using the livewire form component
                            $livewire->save();
                            
                            // Get current endorses after saving
                            $record->refresh();
                            $currentEndorseIds = $record->endorses->pluck('id')->toArray();
                            
                            // Find removed endorses
                            $removedEndorses = collect($originalEndorses)->filter(function($endorse, $id) use ($currentEndorseIds) {
                                return !in_array($id, $currentEndorseIds);
                            });
                            
                            // Create comment if any endorses were removed
                            if ($removedEndorses->isNotEmpty()) {
                                $removedVisadores = $removedEndorses->map(function($endorse) {
                                    return "{$endorse['initials']} ({$endorse['ou_name']})";
                                })->implode(', ');
                                
                                $record->createComment("Se ha eliminado el/los visador(es): {$removedVisadores} del proceso #{$record->id}");
                            }
                            
                            // Redirect to refresh the page
                            return redirect()->to(ProcessResource::getUrl('edit', ['record' => $record->id]));
                        })
                        ->disabled(fn (?Process $record) => static::isProcessSigned($record)),
                ])
                // ->footerActionsAlignment(Alignment::End)
                ->schema([
                    Forms\Components\Repeater::make('endorses')
                        ->relationship()
                        ->disableItemCreation()
                        ->hiddenLabel()
                        ->live()
                        ->deletable(fn (?Process $record) => !static::isProcessSigned($record))
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
                        ->grid(7)
                        ->itemLabel(fn (array $state): ?string => 'Visador: '.OrganizationalUnit::find($state['sent_to_ou_id'])?->name ?? null),

                    Forms\Components\Section::make('Observaciones')
                        ->schema([
                            Forms\Components\Placeholder::make('observations')
                                ->content(function ($record) {
                                    $observations = collect($record['endorses'] ?? [])
                                        ->filter(fn ($endorse) => $endorse['status'] === false)
                                        ->map(fn ($endorse) => 
                                            "{$endorse['approver_at']} - " .
                                            "{$endorse['initials']}: " . 
                                            ($endorse['approver_observation'] ?? 'Sin observaciones')
                                        )
                                        ->join("\n\n");
                                    
                                    return $observations ?: 'No hay observaciones';
                                })
                        ])
                        ->visible(fn ($record) => 
                            collect($record['endorses'] ?? [])->contains(fn ($endorse) => 
                                $endorse['status'] === false
                            )
                        )
                        ->columnSpanFull(),
                ])
                ->hidden(fn (Get $get) => $get('endorse_type') == 'without')
                ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                    $data['establishment_id'] = OrganizationalUnit::find($data['sent_to_ou_id'])?->establishment_id;

                    return $data;
                })
                ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                    $data['module']              = 'Signature Request';
                    $data['subject']             = 'Desde solicitud de firma';
                    $data['document_route_name'] = 'route';
                    $data['digital_signature']   = true;
                    $data['endorse']             = true;

                    return $data;
                })
                // ->maxItems(8)
                // ->defaultItems(1)
                ->columnSpanFull()
                ->visibleOn('edit'),

            

            Forms\Components\Section::make('Firma de Comuna')
                ->description(fn (?Process $record) => $record->endorses->contains(fn ($endorse) => $endorse->status !== true) ? 'Debe esperar la visación completa del convenio para solicitar la firma del alcalde.' : '') 
                ->headerActions([
                    Forms\Components\Actions\Action::make('Enviar Proceso')
                        ->icon('heroicon-m-paper-airplane')
                        ->requiresConfirmation()
                        ->action(function (Process $record, Get $get, $livewire): void {
                            $recipients = $record->municipality->emails;

                            foreach ($recipients as $recipient) {
                                Notification::route('mail', $recipient)->notify(new ProcessCommunePdf($record));
                            }

                            Notifications\Notification::make()
                                ->title('PDF de proceso ' . $record->id . ' enviado a la comuna')
                                ->success()
                                ->send();

                            // establecer fecha de aprobacion y usuario que aprobó
                            $record->update(['sended_to_commune_at' => now()]);

                            // Refresh the page
                            $livewire->redirect(request()->header('Referer'));
                        })
                        ->disabled(fn (?Process $record) => $record->endorses->contains(fn ($endorse) => $endorse->status !== true) ? true : false),
                ])
                ->schema([
                    Forms\Components\DatePicker::make('sended_to_commune_at')
                        ->label('Fecha de envío a la comuna')
                        ->disabled(),
                    Forms\Components\Fieldset::make('Devolución de la comuna')
                        ->schema([
                            Forms\Components\DatePicker::make('returned_from_commune_at')
                                ->label('Fecha de devolución')
                                ->columnSpanFull()
                                ->disabled(),
                            /**
                             * Ejemplo completo de uso de relación file
                             */
                            Forms\Components\Group::make()
                                ->relationship(
                                    'signedCommuneFile',
                                    condition: fn (?array $state): bool => filled($state['storage_path']),
                                ) // Nombre de la relación que está con MorphOne
                                ->schema([
                                    Forms\Components\FileUpload::make('storage_path') // Ruta donde quedará almacenado el archivo
                                        ->label('Archivo firmado por comuna')
                                        ->directory('ionline/documents/agreements/signed-commune-files')
                                        ->storeFileNamesIn('name')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->downloadable(),
                                    Forms\Components\Hidden::make('type') // Campo oculto para almacenar el tipo de archivo dentro del modelo File
                                        ->default('signed_commune_file')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpanFull(),
                            /* Fin del uso de relacion MorphOne de File */

                        ])
                        ->columnSpan(1),
                ])
                // ->footerActions([
                //     Forms\Components\Actions\Action::make('guardar_cambios')
                //         ->icon('bi-save')
                //         ->action('save'),
                //     // ->hidden(fn (?Process $record) => $record->status !== Status::Finished),

                // ])
                ->footerActions([
                    Forms\Components\Actions\Action::make('guardar_cambios')
                        ->icon('bi-save')
                        ->action(function (Process $record, $livewire) {
                            // Save using the livewire form component
                            $livewire->save();
                            
                            // Update returned_from_commune_at only if there's a file
                            $record->update([
                                'returned_from_commune_at' => $record->signedCommuneFile?->exists() ? now() : null,
                            ]);
                            
                            // Redirect to refresh the page
                            return redirect()->to(ProcessResource::getUrl('edit', ['record' => $record->id]));
                        })
                    ->disabled(fn (?Process $record) => $record->endorses->contains(fn ($endorse) => $endorse->status !== true) ? true : false),
                ])
                // ->footerActionsAlignment(Alignment::End)
                ->columns(2)
                ->hiddenOn('create')
                ->columnSpanFull()
                ->visible(fn (?Process $record) => $record->processType->sign_commune),

                
            Forms\Components\Section::make('Firma Director')
            ->description(function (?Process $record) {
                if ($record->processType->sign_commune === true && $record->returned_from_commune_at === null) {
                    return 'Debe esperar que la comuna suba archivo firmado por alcaldía para solicitar firma del director.';
                }
                // if ($record->processType->is_resolution) {
                //     return 'Temporalmente no es posible enviar solicitud de firma para la dirección si es una resolución.';
                // }
                return '';
            })
                ->headerActions([
                    Forms\Components\Actions\Action::make('Descargar')
                        ->label('Descargar')
                        ->icon('heroicon-o-arrow-down-on-square')
                        ->url(fn (Process $record) => Storage::url($record->approval?->filename ?? ''))
                        ->openUrlInNewTab()
                        ->visible(condition: fn (?Process $record) => $record->approval?->status === true),
                    Forms\Components\Actions\Action::make('SolicitarFirmaDirector')
                        ->label('Solicitar Firma Director/a')
                        ->icon('heroicon-m-check-circle')
                        ->requiresConfirmation()
                        ->modalHeading('Solicitar Firma Director/a')
                        ->modalDescription('Si ya existe una firma del director/a, esta será reiniciada y el proceso deberá ser firmado nuevamente.')
                        ->modalSubmitActionLabel('Aceptar')
                        ->action(function (Process $record, array $data): void {
                            $record->createApproval();
                            Notifications\Notification::make()
                                ->title('Solicitud de firma de proceso ' . $record->id . ' a dirección enviada')
                                ->success()
                                ->send();
                        })
                        ->disabled(fn (?Process $record) => ($record->processType->sign_commune === true && $record->returned_from_commune_at === null)),
                        // ->visible(fn (?Process $record) => !$record->processType->is_resolution),
                    Forms\Components\Actions\Action::make('EliminarFirmaDirector')
                        ->label('Eliminar Firma Director/a')
                        ->icon('heroicon-m-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Process $record, array $data): void {
                            $record->deleteApproval();
                            Notifications\Notification::make()
                                ->title('En proceso ' . $record->id . ' se eliminó firma de director(a)')
                                ->success()
                                ->send();
                        })
                        ->visible(fn (?Process $record): bool => 
                            auth()->user()?->can('Agreement: admin') && 
                            $record->approval()->exists()
                        ),
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
                        ->relationship('approval')
                        ->schema([
                            Forms\Components\Placeholder::make('approver_at')
                                ->label('Fecha de aprobación')
                                ->content(fn ($record) => $record['approver_at'] ?? ''),
                                // ->visible(fn ($record) => $record->status === false),
                            Forms\Components\TextInput::make('initials')
                                ->label('Iniciales')
                                ->disabled()
                                ->suffixIcon('heroicon-m-check-circle')
                                ->suffixIconColor(fn ($record) => match ($record['status'] ?? null) {
                                    true    => 'success',
                                    false   => 'danger',
                                    default => 'gray',
                                }),
                            Forms\Components\Placeholder::make('approver_observation')
                                ->label('Observaciones')
                                ->content(fn ($record) => $record['approver_observation'] ?? 'Sin observaciones'),
                                // ->visible(fn ($record) => $record->status === false),
                        ])
                        ->columns(2)
                        ->columnSpan(2)
                        ->visible(fn (?Process $record) => $record->approval()->exists()),
                ])
                ->footerActions([
                    Forms\Components\Actions\Action::make('guardar_cambios')
                        ->icon('bi-save')
                        // ->action('save'),
                        ->action(function (Process $record, $livewire) {
                            
                            // Save using the livewire form component
                            $livewire->save();

                            // update the approval signer initials
                            $record->updateApprovalSignerInitials();
                            
                            // Redirect to refresh the page
                            return redirect()->to(ProcessResource::getUrl('edit', ['record' => $record->id]));
                        }),
                ])
                // ->footerActionsAlignment(Alignment::End)
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
                        ->relationship(
                            'finalProcessFile',
                            condition: fn (?array $state): bool => filled($state['storage_path']),
                        )
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
                ->hiddenOn('create')
                ->visible(fn (?Process $record): bool => $record->processType->is_resolution),

            Forms\Components\Section::make('Procesos Dependientes')
                ->headerActions([
                    Forms\Components\Actions\Action::make('Crear proceso dependiente')
                        ->icon('heroicon-m-plus-circle')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('process_type_id')
                                ->label('Tipo de proceso')
                                ->options(function (Process $record) {
                                    return ProcessType::where(function ($query) use ($record) {
                                        $query->whereIn('id', $record->processType->childsProcessType->pluck('id'))
                                            ->orWhere(function ($query) {
                                                $query->where('is_dependent', true)
                                                    ->doesntHave('fatherProcessType');
                                            });
                                    })
                                        ->pluck('name', 'id');
                                })
                                ->required(),
                            Forms\Components\Select::make('period')
                                ->label('Periodo')
                                ->required()
                                ->live()
                                ->options(function () {
                                    $currentYear = now()->addYear()->year;
                                    $years = [];
                                    for ($i = 0; $i < 6; $i++) {  // Corregido: $i en lugar de i
                                        $years[$currentYear - $i] = $currentYear - $i;
                                    }
                            
                                    return $years;
                                })
                                ->default(now()->year)
                                ->helperText('Una vez seleccionaro el periodo, espere unos segundos para que se carguen los programas'),
                            Forms\Components\Select::make('program_id')
                                ->label('Programa')
                                ->relationship('program', 'name', function (Builder $query, callable $get) {
                                    $query->where('is_program', true)
                                        ->where('period', $get('period'))
                                        ->whereHas('referers', function ($query) {
                                            $query->where('user_id', auth()->id());
                                        });
                                })
                                ->helperText('Solo programas en los que eres referente')
                                ->required(),

                        ])
                        ->action(function (Process $record, array $data) {
                            $process_id = $record->createNextProcess($data['process_type_id'], $data['period'], $data['program_id']);

                            return redirect()->to(static::getUrl('edit', ['record' => $process_id]));
                        }),
                ])
                ->schema([
                    Forms\Components\Repeater::make('nextProcesses')
                        ->hiddenLabel(true)
                        ->relationship('nextProcesses')
                        ->simple(
                            Forms\Components\TextInput::make('process_type_name')
                                ->label('Nombre del proceso')
                                ->disabled()
                                /** No encontré mejor forma para que me muestre el nombre del proceso, ya que processType.name no me funcionó */
                                ->afterStateHydrated(function (Get $get, Set $set) {
                                    $set('process_type_name', ProcessType::find($get('process_type_id'))?->name);
                                })
                                ->suffixAction(
                                    Forms\Components\Actions\Action::make('ir_al_proceso')
                                        ->label('Ir al proceso')
                                        ->icon('bi-link')
                                        ->action(fn (Get $get) => redirect()->to(ProcessResource::getUrl('edit', ['record' => $get('id')])))
                                ),
                        )
                        ->deletable(false)
                        ->addable(false),
                ])
                ->columns(2)
                ->hiddenOn('create')
                ->columnSpanFull(),

            Forms\Components\Section::make('Archivos adjuntos')
                ->schema([
                    Forms\Components\Repeater::make('files')
                        ->hiddenLabel(true)
                        ->label('Archivos')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
                                ->required(),
                            Forms\Components\FileUpload::make('storage_path')
                                ->label('Archivo')
                                ->directory('ionline/documents/agreements/processes-files')
                                ->acceptedFileTypes(['application/pdf'])
                                ->downloadable()
                                ->required(),
                        ])
                        ->columns(2)
                        ->hiddenOn('create')
                        ->columnSpanFull(),
                ])
                ->hiddenOn('create'),

        ];
    }

    /**
     *  Formulario par Jurídico
     */
    protected static function legallyFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Documento')
                ->footerActions([
                    // Forms\Components\Actions\Action::make('guardar_cambios')
                    //     ->icon('bi-save')
                    //     ->action('save'),
                    Forms\Components\Actions\Action::make('Ver')
                        ->icon('heroicon-m-eye')
                        ->url(fn (Process $record) => route('documents.agreements.processes.view', [$record]))
                        ->openUrlInNewTab(),
                ])
                ->schema([
                    TinyEditor::make('document_content')
                        ->hiddenLabel()
                        ->profile('ionline')
                        ->disabled(),
                    // ->disabled(fn (?Process $record): bool => $record->revision_by_lawyer_user_id !== null),
                ])
                ->hiddenOn('create'),

            Forms\Components\Section::make('Revisiones')
                ->headerActions([
                    Forms\Components\Actions\Action::make('approbe')
                        ->label('Aprobar Revisión')
                        ->icon('heroicon-m-check-circle')
                        ->requiresConfirmation()
                        ->action(function (Process $record, Get $get, $livewire): void {
                            // Guardar cambios del documento
                            // $record->update(['content' => $get('document_content')]);

                            // Establecer fecha de aprobacion y usuario que aprobó
                            $record->update(['revision_by_lawyer_at' => now(), 'revision_by_lawyer_user_id' => auth()->id()]);

                            // Notificar a referente y administradores del módulo
                            $recipients = User::permission('Agreement: admin')
                                ->where('establishment_id', $record->establishment_id)
                                ->get();

                            Notifications\Notification::make()
                                ->title('Nuevo proceso N°' . $record->id . ' aprobado por jurídico')
                                ->actions([
                                    Notifications\Actions\Action::make('IrAlProceso')
                                        ->button()
                                        ->url(ProcessResource::getUrl('edit', [$record->id]))
                                        ->markAsRead(),
                                ])
                                ->sendToDatabase($recipients);

                            // Notificar al referente.
                            Notifications\Notification::make()
                                ->title('Proceso N°' . $record->id . ' aprobado por jurídico')
                                ->actions([
                                    Notifications\Actions\Action::make('IrAlProceso')
                                        ->button()
                                        ->url(ProcessResource::getUrl('edit', [$record->id]))
                                        ->markAsRead(),
                                ])
                                ->sendToDatabase($record->program->referers);

                            Notifications\Notification::make()
                                ->title('Proceso N°' . $record->id . ' aprobado por jurídico')
                                ->success()
                                ->send();

                            // Refresh the page
                            $livewire->redirect(request()->header('Referer'));
                        })
                        ->disabled(fn (?Process $record): bool => $record->revision_by_lawyer_at !== null),
                ])
                ->schema([
                    Forms\Components\Fieldset::make('Jurídico')
                        // ->schema([
                        //     Forms\Components\DatePicker::make('revision_by_lawyer_at')
                        //         ->label('Fecha de revisión')
                        //         ->disabled(),
                        //     Forms\Components\Placeholder::make('Revisado por')
                        //         ->content(fn (?Process $record) => $record->revisionByLawyerUser?->shortName),
                        // ])
                        ->schema([
                            Forms\Components\DatePicker::make('sended_revision_lawyer_at')
                                ->label('Fecha de solicitud')
                                ->disabled(),
                            Forms\Components\Placeholder::make('Solicitado por')
                                ->content(fn (?Process $record) => $record->lawyerRevisionSenderUser?->shortName ?? 'N/A'),
                            Forms\Components\DatePicker::make('revision_by_lawyer_at')
                                ->label('Fecha de revisión')
                                ->disabled(),
                            Forms\Components\Placeholder::make('Revisado por')
                                ->content(fn (?Process $record) => $record->revisionByLawyerUser?->shortName ?? 'N/A'),
                        ])
                        ->columnSpan(1)
                        ->columns(2),

                ])
                ->columns(2)
                ->hiddenOn('create'),

        ];
    }
}
