<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessTypeResource\Pages;
use App\Models\Documents\Agreements\ProcessType;
use App\Services\ColorCleaner;
use App\Services\TableCleaner;
use App\Services\TextCleaner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ProcessTypeResource extends Resource
{
    protected static ?string $model = ProcessType::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $modelLabel = 'tipo de proceso';

    protected static ?string $pluralModelLabel = 'tipos de proceso';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del proceso')
                    ->required()
                    ->helperText('Ej: Convenio, Adendum v2, Resolución 2021, etc.')
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción')
                    ->maxLength(255)
                    ->columnSpan(3)
                    ->default(null),
                Forms\Components\Toggle::make('revision_commune')
                    ->label('Revisión Comuna')
                    ->inline(false)
                    ->default(false)
                    ->helperText('Indica si el proceso requiere revisión por la comuna'),
                Forms\Components\Toggle::make('sign_commune')
                    ->label('Firma Comuna')
                    ->inline(false)
                    ->default(false)
                    ->helperText('Indica si el proceso requiere firma por la comuna'),
                Forms\Components\Toggle::make('is_resolution')
                    ->label('Es Resolución')
                    ->inline(false)
                    ->helperText('El proceso es una resolución, hace que la firma del director/a salga antes de la distribución')
                    ->required(),
                Forms\Components\Toggle::make('is_certificate')
                    ->label('Es Certificado')
                    ->inline(false)
                    ->helperText('Aparecerá en el listado de certificados en vez de en el de procesos')
                    ->required(),
                 Forms\Components\Toggle::make('active')
                    ->label('Activo')
                    ->inline(false)
                    ->helperText('Si está desactivado no aparecerá en el listado de procesos/certificdos')
                    ->required(),
                Forms\Components\Fieldset::make('Esto es los procesos que tienen un paso anterior')
                    ->schema([
                        Forms\Components\Toggle::make('is_dependent')
                            ->label('Es Dependiente')
                            ->inline(false)
                            ->columns(1),
                        Forms\Components\Select::make('father_process_type_id')
                            ->relationship(
                                'fatherProcessType', 
                                'name',
                                fn ($query, $record) => $query->when(
                                    $record,
                                    fn ($q) => $q->where('id', '!=', $record->id)
                                )
                            )
                            ->label('Tipo de Proceso Padre')
                            ->helperText('El proceso padre que se debe completar antes de este')
                            ->columnSpan(2),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Forms\Components\Section::make('Plantilla')
                    ->relationship('template')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->maxLength(255)
                            ->required(),
                        TinyEditor::make('content')
                            ->profile('ionline')
                            ->label('Contenido')
                            ->required()
                            ->columnSpanFull()
                            ->hintActions(
                                [
                                    Forms\Components\Actions\Action::make('limpiarTabla')
                                        ->icon('heroicon-m-clipboard')
                                        ->requiresConfirmation()
                                        ->action(function (Get $get, Set $set) {
                                            $content        = $get('content');
                                            $cleanedContent = TableCleaner::clean($content);
                                            $set('content', $cleanedContent);
                                        }),

                                    Forms\Components\Actions\Action::make('limpiarTexto')
                                        ->icon('heroicon-m-clipboard')
                                        ->requiresConfirmation()
                                        ->action(function (Get $get, Set $set) {
                                            $content        = $get('content');
                                            $cleanedContent = TextCleaner::clean($content);
                                            $set('content', $cleanedContent);
                                        }),

                                    Forms\Components\Actions\Action::make('limpiarColor')
                                        ->icon('heroicon-m-clipboard')
                                        ->requiresConfirmation()
                                        ->action(function (Get $get, Set $set) {
                                            $content        = $get('content');
                                            $cleanedContent = ColorCleaner::clean($content);
                                            $set('content', $cleanedContent);
                                        }),
                                ]
                            ),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(5);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('revision_commune')
                    ->label('Revisión Comuna')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('sign_commune')
                    ->label('Firma Comuna')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_dependent')
                    ->label('Dependiente')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_resolution')
                    ->label('Resolución')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fatherProcessType.name')
                    ->label('Proceso Padre')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('childsProcessType.name')
                    ->label('Procesos Hijos')
                    ->wrap()
                    ->bulleted()
                    ->searchable(),
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
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->paginated([50, 100]);
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
            'index'  => Pages\ListProcessTypes::route('/'),
            'create' => Pages\CreateProcessType::route('/create'),
            'edit'   => Pages\EditProcessType::route('/{record}/edit'),
        ];
    }
}
