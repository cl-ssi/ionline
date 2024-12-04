<?php

namespace App\Filament\Clusters\Documents\Resources;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\ApprovalResource\Pages;
use App\Filament\Clusters\Documents\Resources\ApprovalResource\RelationManagers;
use App\Models\Documents\Approval;
use App\Models\Documents\DigitalSignature;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ApprovalResource extends Resource
{
    protected static ?string $model = Approval::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'aprobación';

    protected static ?string $pluralModelLabel = 'aprobaciones';

    protected static ?string $navigationGroup = 'Documentos';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('module')
                    ->label('Módulo')
                    ->disabled(),
                Forms\Components\TextInput::make('approvable_type')
                    ->maxLength(255)
                    ->default(null)
                    ->disabled(),
                Forms\Components\TextInput::make('approvable_id')
                    ->numeric()
                    ->disabled()
                    ->default(null),
                Forms\Components\TextInput::make('initials')
                    ->maxLength(6)
                    ->default(null)
                    ->disabled(),
                // Forms\Components\TextInput::make('module_icon')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('document_route_name')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('document_route_params')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('document_pdf_path')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\Select::make('sent_to_ou_id')
                    ->relationship('sentToOu', 'id')
                    ->searchable()
                    ->columnSpan(2),
                Forms\Components\Select::make('sent_to_user_id')
                    ->relationship('sentToUser', 'full_name')
                    ->searchable()
                    ->columnSpan(2),
                Forms\Components\Select::make('approver_ou_id')
                    ->relationship('approverOu', 'id')
                    ->columnSpan(2)
                    ->searchable(),
                Forms\Components\Select::make('approver_id')
                    ->relationship('approver', 'id')
                    ->columnSpan(2)
                    ->searchable(),
                Forms\Components\TextInput::make('approver_observation')
                    ->maxLength(255)
                    ->columnSpan(3)
                    ->default(null),
                Forms\Components\DateTimePicker::make('approver_at'),
                Forms\Components\Toggle::make('status'),
                // Forms\Components\Toggle::make('approvable_callback')
                //     ->required(),
                // Forms\Components\TextInput::make('callback_controller_method')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('callback_controller_params')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\Textarea::make('callback_feedback_inputs')
                //     ->columnSpanFull(),
                Forms\Components\Toggle::make('active')
                    ->required(),

                Forms\Components\Toggle::make('digital_signature')
                    ->required(),
                Forms\Components\Toggle::make('endorse')
                    ->required(),
                Forms\Components\TextInput::make('position')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('start_y')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('filename')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('previous_approval_id')
                    ->relationship('previousApproval', 'id')
                    ->searchable(),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('module')
                    ->label('Módulo')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('module_icon')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->wrap()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('document_route_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('document_route_params')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('document_pdf_path')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('sent_to_ou_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('sentToOu.name')
                    ->label('Enviado UO')
                    ->limit(40)
                    ->sortable(),
                Tables\Columns\TextColumn::make('sentToUser.shortName')
                    ->label('Enviado a')
                    ->searchable(['full_name'])
                    ->sortable(),
                // Tables\Columns\TextColumn::make('sent_to_user_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('initials')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('approver_ou_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('approver.shortName')
                    ->label('Aprobador')
                    ->searchable(['full_name'])
                    ->sortable(),
                // Tables\Columns\TextColumn::make('approver_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('approver_observation')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('approver_at')
                //     ->dateTime()
                //     ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                // Tables\Columns\IconColumn::make('approvable_callback')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('callback_controller_method')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('callback_controller_params')
                //     ->searchable(),
                // Tables\Columns\IconColumn::make('active')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('previousApproval.id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('digital_signature')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('endorse')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('position')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('start_y')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('filename')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('approvable_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('approvable_id')
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
                //
            ])
            ->actions([
                Tables\Actions\Action::make('signature')
                ->form([
                    Forms\Components\Grid::make('Label')
                        ->schema([
                            Forms\Components\TextInput::make('otp')
                                ->label('OTP')
                                ->numeric()
                                ->required()
                                ->columns(1),
                            Forms\Components\TextInput::make('approver_observation')
                                ->label('Observaciones')
                                ->columnSpan(3)
                        ])
                        ->columns(4)
                ])
                ->label('Firmar')
                ->icon('heroicon-o-pencil')
                ->extraModalFooterActions(fn(Tables\Actions\Action $action): array => [
                    $action->makeModalSubmitAction('rechazar', arguments: ['reject' => true])->color('danger'),
                ])
                ->action(function (array $data, array $arguments, Approval $record): void {
                    if ( $arguments['reject'] ) {
                        // Si es un rechazo, se actualiza el registro con la observación del aprobador y se marca como rechazado (status = False)
                        $record->update(['approver_observation' => $data['approver_observation'], 'status' => false]);
                    } else {
                        $digitalSignature = new DigitalSignature();
                        $status           = $digitalSignature->signature(
                            auth()->user(),
                            $data['otp'],
                            array(Storage::get($record->document_pdf_path)),
                            array(['margin-bottom' => 20])
                        );

                        if ( $status == true ) {
                            $digitalSignature->storeFirstSignedFile('ionline/approvals/signed_files/' . basename($record->original_file_path));
                            $record->update(['status' => true]);
                            Notification::make()
                                ->title('Archivo firmado correctamente')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title($digitalSignature->error)
                                ->danger()
                                ->send();
                        }
                    }
                })
                ->modalSubmitActionLabel('Firmar')
                ->modalWidth(MaxWidth::SevenExtraLarge)
                ->modalContent(fn(Approval $record): View => view('filament.documents.pdf-viewer-modal', [
                    'pdfUrl' => Storage::url($record->original_file_path),
                ]))
                ->hidden(fn(Approval $record): bool => $record->status ?? false),
            Tables\Actions\Action::make('pdf')
                ->label('')
                ->color('success')
                ->icon('heroicon-o-document')
                ->url(fn(Approval $record) => Storage::url('ionline/signature_requests/signed_files/' . basename($record->original_file_path)))
                ->openUrlInNewTab()
                ->visible(fn(Approval $record): bool => $record->status ?? false),
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
            'index' => Pages\ListApprovals::route('/'),
            'create' => Pages\CreateApproval::route('/create'),
            'edit' => Pages\EditApproval::route('/{record}/edit'),
        ];
    }
}
