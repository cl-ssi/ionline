<?php

namespace App\Filament\Clusters\Documents\Resources\Documents;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Documents\ManualResource\Pages;
use App\Filament\Clusters\Documents\Resources\Documents\ManualResource\RelationManagers;
use App\Models\Documents\Manual;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManualResource extends Resource
{
    protected static ?string $model = Manual::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('module_id')
                    ->relationship('module', 'name'),
                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'full_name')
                    ->searchable(),
                Forms\Components\TextInput::make('version')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->fileAttachmentsDirectory('documents/manuals/images')
                    ->fileAttachmentsVisibility('private')
                    ->columnSpanFull(),
                Forms\Components\KeyValue::make('modifications')
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('module.name')
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
                        $clonedManual->save();

                        return redirect()->route('filament.intranet.documents.resources.documents.manuals.edit', $clonedManual);
                    })
                    ->icon('heroicon-o-document-duplicate')
                    ->requiresConfirmation()
                    ->color('primary'),
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
