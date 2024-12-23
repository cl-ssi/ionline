<?php

namespace App\Filament\Clusters\Documents\Resources;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\ManualResource\Pages;
use App\Filament\Clusters\Documents\Resources\ManualResource\RelationManagers;
use App\Models\Documents\Manual;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ManualResource extends Resource
{
    protected static ?string $model = Manual::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'manual';

    protected static ?string $pluralModelLabel = 'manuales';

    protected static ?string $navigationGroup = 'Documentos';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('module_id')
                    ->label('Módulo')
                    ->relationship('module', 'name'),
                Forms\Components\Select::make('author_id')
                    ->label('Autor')
                    ->relationship('author', 'full_name')
                    ->searchable(),
                Forms\Components\TextInput::make('version')
                    ->label('Versión')
                    ->numeric()
                    ->step(0.1)
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\KeyValue::make('modifications')
                    ->label('Modificaciones')
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->fileAttachmentsDirectory('documents/manuals/images')
                    ->fileAttachmentsVisibility('private')
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('module.name')
                    ->label('Módulo')
                    ->numeric()
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
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('clone')
                    ->label('Clonar')
                    ->action(function (Manual $record, $data) {
                        $clonedManual = $record->replicate();
                        $clonedManual->file = null;
                        $clonedManual->version = 1.0;
                        $clonedManual->save();

                        return redirect()->route('filament.intranet.documents.resources.documents.manuals.edit', $clonedManual);
                    })
                    ->icon('heroicon-o-document-duplicate')
                    ->requiresConfirmation()
                    ->color('primary'),
                Tables\Actions\Action::make('Pdf')
                    ->url(fn (Manual $record): string => Storage::url($record->file))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye')
                    ->visible(fn (Manual $record): bool => !empty($record->file)),
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
            'index' => Pages\ListManuals::route('/'),
            'create' => Pages\CreateManual::route('/create'),
            'edit' => Pages\EditManual::route('/{record}/edit'),
        ];
    }
}
