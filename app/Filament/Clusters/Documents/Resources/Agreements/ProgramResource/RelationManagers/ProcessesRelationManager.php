<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessesRelationManager extends RelationManager
{
    protected static string $relationship = 'processes';

    protected static ?string $title = 'Procesos';

    protected static ?string $modelLabel = 'proceso';

    protected static ?string $pluralModelLabel = 'procesos';

    public function form(Form $form): Form
    {
        return ProcessResource::form($form);
    }
     
    public function table(Table $table): Table
    {
        return ProcessResource::table($table)
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
