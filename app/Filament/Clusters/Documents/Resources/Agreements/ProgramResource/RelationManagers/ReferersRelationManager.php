<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReferersRelationManager extends RelationManager
{
    protected static string $relationship = 'referers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('fathers_family')
            ->columns([
                Tables\Columns\TextColumn::make('shortName'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    // ->modalWidth('2xl')
                    ->recordSelectSearchColumns(['full_name', 'name', 'fathers_family', 'mothers_family']),
                    // ->recordSelectOptionsQuery(fn ($query) => $query->filterByName(request('search'))),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DetachBulkAction::make(),
                // ]),
            ]);
    }
}
