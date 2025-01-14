<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\CertificateResource\Pages;
use App\Models\Documents\Agreements\Certificate;
use App\Services\ColorCleaner;
use App\Services\TableCleaner;
use App\Services\TextCleaner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

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
                    ->default(now()->year),
                Forms\Components\Select::make('program_id')
                    ->label('Programa')
                    ->relationship('program', 'name', fn (Builder $query, callable $get) => $query->where('is_program', true)->where('period', $get('period')))
                // ->hiddenOn(CertificateesRelationManager::class)
                    ->required()
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
                            }),
                        // ->disabled(fn (?Certificate $record) => $record->status === Status::Finished),
                    ])
                    ->footerActionsAlignment(Alignment::End)
                    ->schema([
                        TinyEditor::make('content')::make('document_content')
                            ->hiddenLabel()
                            ->profile('ionline')
                        // ->disabled(fn(?Certificate $record) => $record->status === Status::Finished)
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
                                        }),
                                    // ->disabled(fn(?Certificate $record) => $record->status === Status::Finished),

                                    Forms\Components\Actions\Action::make('limpiarTexto')
                                        ->icon('heroicon-m-clipboard')
                                        ->requiresConfirmation()
                                        ->action(function (Get $get, Set $set) {
                                            $content        = $get('document_content');
                                            $cleanedContent = TextCleaner::clean($content);
                                            $set('document_content', $cleanedContent);
                                        }),
                                    // ->disabled(fn(?Certificate $record) => $record->status === Status::Finished),

                                    Forms\Components\Actions\Action::make('limpiarColor')
                                        ->icon('heroicon-m-clipboard')
                                        ->requiresConfirmation()
                                        ->action(function (Get $get, Set $set) {
                                            $content        = $get('document_content');
                                            $cleanedContent = ColorCleaner::clean($content);
                                            $set('document_content', $cleanedContent);
                                        }),
                                    // ->disabled(fn(?Certificate $record) => $record->status === Status::Finished),
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
                    ])
                    ->schema([
                        Forms\Components\Repeater::make('approvals')
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
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->sortable(),
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
            'index'  => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit'   => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
