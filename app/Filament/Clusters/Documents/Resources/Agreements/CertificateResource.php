<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Establishment;
use App\Services\TextCleaner;
use App\Services\ColorCleaner;
use App\Services\TableCleaner;
use Filament\Resources\Resource;
use App\Filament\Clusters\Documents;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Documents\Agreements\Status;
use App\Models\Documents\Agreements\Certificate;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use App\Filament\Clusters\Documents\Resources\Agreements\CertificateResource\Pages;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $modelLabel = 'certificado';

    protected static ?string $pluralModelLabel = 'certificados';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('process_type_id')
                    ->label('Tipo de Certificado')
                    ->relationship(
                        'processType',
                        'name',
                        fn (Builder $query, callable $get) => $query->where('is_certificate', true))
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
                    ->disabledOn('edit'),
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
                // ->hiddenOn(CertificateesRelationManager::class)
                    ->required()
                    ->visibleOn('create')
                    ->columnSpan(2),
                Forms\Components\Select::make('program_id')
                    ->label('Programa')
                    ->relationship('program', 'name')
                // ->hiddenOn(CertificateesRelationManager::class)
                    ->required()
                    ->visibleOn('edit')
                    ->disabled()
                    ->columnSpan(2),
                Forms\Components\Select::make('commune_id')
                    ->label('Comuna')
                    ->relationship('commune', 'name'),
                Forms\Components\TextInput::make('number')
                    ->label('Número')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('date')
                    ->label('Fecha'),
                // Forms\Components\TextInput::make('status')
                //     ->required(),
                Forms\Components\Section::make('Documento')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('CrearDocumento')
                            ->label('Crear documento del proceso')
                            ->icon('heroicon-m-document')
                            ->requiresConfirmation()
                            ->action(function (Certificate $record, Set $set) {
                                $set('document_content', $record->processType->template->parseTemplate($record));
                            })
                            ->disabled(fn (?Certificate $record) => $record->status === Status::Finished),
                    ])
                    ->footerActions([
                        Forms\Components\Actions\Action::make('Volver a editar')
                            ->icon('heroicon-m-pencil-square')
                            ->requiresConfirmation()
                            ->action(function (Certificate $record) {
                                $record->update(['status' => Status::Draft]);
                                // $record->createComment('El certificado ha vuelto a estado de borrador.');
                                return redirect()->to(CertificateResource::getUrl('edit', ['record' => $record->id]));
                            })
                            ->disabled(fn (?Certificate $record) => $record->status === Status::Draft),
                        Forms\Components\Actions\Action::make('guardar_cambios')
                            ->icon('bi-save')
                            // ->action('save')
                            // ->action(function (Certificate $record) {
                            //     $record->save();
                            //     $record->update(['status' => Status::Finished]);
                            //     return redirect()->to(CertificateResource::getUrl('edit', ['record' => $record->id]));
                            // })
                            ->action(function (Certificate $record, $livewire) {
                                // Save using the livewire form component
                                $livewire->save();

                                $record->update(['status' => Status::Finished]);
                                
                                // Redirect to refresh the page
                                return redirect()->to(CertificateResource::getUrl('edit', ['record' => $record->id]));
                            })
                            ->disabled(fn (?Certificate $record) => $record->status === Status::Finished),
                        Forms\Components\Actions\Action::make('Ver')
                            ->icon('heroicon-m-eye')
                            ->url(fn (Certificate $record) => route('documents.agreements.certificates.view', [$record]))
                            ->openUrlInNewTab()
                            ->disabled(fn (?Certificate $record) => $record->status === Status::Draft),
                    ])
                    ->footerActionsAlignment(Alignment::End)
                    ->schema([
                        TinyEditor::make('content')::make('document_content')
                            ->hiddenLabel()
                            ->profile('ionline')
                            ->disabled(fn (?Certificate $record) => $record->status === Status::Finished)
                        // Forms\Components\Textarea::make('text')
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
                                        ->disabled(fn (?Certificate $record) => $record->status === Status::Finished),

                                    Forms\Components\Actions\Action::make('limpiarTexto')
                                        ->icon('heroicon-m-clipboard')
                                        ->requiresConfirmation()
                                        ->action(function (Get $get, Set $set) {
                                            $content        = $get('document_content');
                                            $cleanedContent = TextCleaner::clean($content);
                                            $set('document_content', $cleanedContent);
                                        })
                                        ->disabled(fn (?Certificate $record) => $record->status === Status::Finished),

                                    Forms\Components\Actions\Action::make('limpiarColor')
                                        ->icon('heroicon-m-clipboard')
                                        ->requiresConfirmation()
                                        ->action(function (Get $get, Set $set) {
                                            $content        = $get('document_content');
                                            $cleanedContent = ColorCleaner::clean($content);
                                            $set('document_content', $cleanedContent);
                                        })
                                        ->disabled(fn (?Certificate $record) => $record->status === Status::Finished),
                                ]
                            )
                            ->columnSpanFull(),
                    ])
                    ->hiddenOn('create'),

                Forms\Components\Section::make('Visaciones')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('endorseAndApprovalRequest')
                            ->label('Visar y solicitar firma')
                            ->icon('heroicon-m-check-circle')
                            ->requiresConfirmation()
                            ->form([
                                Forms\Components\Select::make('referer_id')
                                    ->label('Referente')
                                    ->options(fn (Certificate $record) => $record->program->referers->pluck('full_name', 'id'))
                                    ->required(),
                            ])
                            ->action(function (Certificate $record, array $data): void {
                                $record->createApprovals($data['referer_id']);
                                // $this->refreshFormData([
                                //     'status',
                                // ]);
                                Notification::make()
                                    ->title('Visado solicitado')
                                    ->success()
                                    ->send();
                            })
                            ->disabled(fn (?Certificate $record) => $record->approvals->isNotEmpty()),
                        Forms\Components\Actions\Action::make('download_certificate')
                            ->label('Descargar Certificado')
                            ->icon('heroicon-o-arrow-down-tray')
                            ->url(fn (Certificate $record) => $record->signer ? Storage::url($record->signer->filename) : '#')
                            ->openUrlInNewTab()
                            ->visible(fn (Certificate $record) => $record->status->value === 'finished' && $record->signer),

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
                            ->action(function (Certificate $record, array $data): void {
                                $record->addNewEndorse($data);
                                // Notifications\Notification::make()
                                //     ->title('Visado solicitado')
                                //     ->success()
                                //     ->send();
                                redirect(request()->header('Referer')); // Redirige al usuario a la misma página
                            }),
                    ])
                    // ->schema([
                    //     Forms\Components\Repeater::make('approvals')
                    //         ->relationship()
                    //         ->addActionLabel('Agregar visación')
                    //         ->hiddenLabel()
                    //         ->addable(false)
                    //         ->deletable(false)
                    //         ->simple(
                    //             Forms\Components\TextInput::make('initials')
                    //                 ->label('Nombre')
                    //                 ->disabled()
                    //                 ->suffixIcon('heroicon-m-check-circle')
                    //                 ->suffixIconColor(fn ($record) => match ($record['status'] ?? null) {
                    //                     true    => 'success',
                    //                     false   => 'danger',
                    //                     default => 'gray',
                    //                 }),
                    //         )
                    //         ->columnSpanFull()
                    //         ->grid(7),

                    // ])
                    ->schema([
                        Forms\Components\Repeater::make('approvals')
                            ->relationship()
                            ->disableItemCreation()
                            ->hiddenLabel()
                            ->live()
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
                                        $observations = collect($record['approvals'] ?? [])
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
                                collect($record['approvals'] ?? [])->contains(fn ($endorse) => 
                                    $endorse['status'] === false
                                )
                            )
                            ->columnSpanFull(),
                    ])
                    ->hiddenOn('create')
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('processType.name')
                    ->label('Tipo de Certificado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('period')
                    ->label('Periodo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program.name')
                    ->label('Programa')
                    ->wrap()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('commune.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('number')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('date')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('status'),
                // Tables\Columns\TextColumn::make('establishment.name')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\ImageColumn::make('approvals.avatar')
                    ->label('Aprobaciones')
                    ->circular()
                    ->stacked(),
                // Tables\Columns\TextColumn::make('status')
                //     ->label('Estado')
                //     ->badge()
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
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Ver')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Certificate $record) => route('documents.agreements.certificates.view', [$record]))
                    ->color('secondary')
                    ->openUrlInNewTab()
                    ->hidden(fn (Certificate $record) => $record->status->value === 'finished'),
                Tables\Actions\Action::make('Ver')
                    ->icon('heroicon-m-eye')
                    ->color('success')
                    ->url(fn (Certificate $record) => Storage::url($record->signer->filename))
                    ->openUrlInNewTab()
                    ->hidden(fn (Certificate $record) => !$record->signer || $record->status->value === 'draft'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index'  => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit'   => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
