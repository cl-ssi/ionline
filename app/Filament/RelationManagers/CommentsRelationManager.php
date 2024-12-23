<?php

namespace App\Filament\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = 'Comentarios';

    protected static ?string $modelLabel = 'comentario';

    protected static ?string $pluralModelLabel = 'comentarios';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('body')
                    ->hiddenLabel()
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(1255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.shortName')
                    ->label('Autor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_from_system')
                    ->label('Sistema')
                    ->boolean()
                    ->sortable()
                    ->falseIcon(''),
                Tables\Columns\TextColumn::make('body')
                    ->label('Comentario')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_from_system')
                    ->label('Es del Sistema')
                    ->options([
                        'true' => 'Sí',
                        'false' => 'No',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
