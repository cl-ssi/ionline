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
                    ->columnSpan(4)
                    ->default(null),
                Forms\Components\Toggle::make('bilateral')
                    ->label('Bilateral')
                    ->inline(false)
                    ->required(),
                Forms\Components\Toggle::make('has_resolution')
                    ->label('Tiene Resolución')
                    ->inline(false)
                    ->required(),
                Forms\Components\Toggle::make('is_certificate')
                    ->label('Es Certificado')
                    ->inline(false)
                    ->required(),
                Forms\Components\Fieldset::make('Esto es para las resoluciones')
                    ->schema([
                        Forms\Components\Toggle::make('is_dependent')
                            ->label('Es Dependiente')
                            ->inline(false),
                        Forms\Components\Select::make('father_process_type_id')
                            ->relationship('fatherProcessType', 'name')
                            ->label('Tipo de Proceso Padre'),
                    ])
                    ->columnSpan(2),
                Forms\Components\Toggle::make('active')
                    ->label('Activo')
                    ->inline(false)
                    ->required(),

                Forms\Components\Section::make('Plantilla')
                    ->relationship('template')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->maxLength(255)
                            ->required(),
                        TinyEditor::make('content')
                        // Forms\Components\RichEditor::make('content')
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
            ->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('bilateral')
                    ->label('Bilateral')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_dependent')
                    ->label('Dependiente')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_resolution')
                    ->label('Resolución')
                    ->boolean(),
                Tables\Columns\TextColumn::make('childProcessType.name')
                    ->label('Sigiente Proceso')
                    ->wrap()
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
