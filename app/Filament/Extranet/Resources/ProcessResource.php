<?php

namespace App\Filament\Extranet\Resources;

use App\Enums\Documents\Agreements\Status;
use App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers\ProcessesRelationManager;
use App\Filament\Extranet\Resources\ProcessResource\Pages;
use App\Filament\Extranet\Resources\ProcessResource\RelationManagers;
use App\Models\Documents\Agreements\Process;
use App\Models\Documents\Agreements\Signer;
use App\Models\Establishment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\RelationManagers\CommentsRelationManager;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Collection;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ProcessResource extends Resource
{
    protected static ?string $model = Process::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    // protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $modelLabel = 'proceso';

    protected static ?string $pluralModelLabel = 'procesos';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Documento')
                    ->headerActions([
                    ])
                    ->footerActions([
                        Forms\Components\Actions\Action::make('aprobar_cambios')
                            ->icon('bi-save')
                            ->action('save'),
                    ])
                    ->footerActionsAlignment(Alignment::End)
                    ->schema([
                        TinyEditor::make('content')::make('document_content')
                            ->hiddenLabel()
                            ->profile('ionline')
                            ->disabled(fn(?Process $record) => $record->status === Status::Finished),
                    ])
                    ->hiddenOn('create'),

            Forms\Components\Section::make('Comuna')
                ->schema([
                    Forms\Components\Fieldset::make('Devolución de la comuna')
                        ->schema([
                            Forms\Components\DatePicker::make('returned_from_commune_at')
                                ->label('Fecha de devolución')
                                ->columnSpanFull(),
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
                                        ->maxSize(5120) // Tamaño máximo de archivo en KB (5MB)
                                        ->helperText('El tamaño máximo del archivo es de 5MB.'),
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
                Tables\Filters\SelectFilter::make('comuna')
                    ->relationship(
                        name: 'commune',
                        titleAttribute: 'name',
                    )
                    ->searchable(),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make()
                    // ->url(fn (Process $record) => route('documents.agreements.processes.view', [$record]))
                    // ->openUrlInNewTab(),
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
}