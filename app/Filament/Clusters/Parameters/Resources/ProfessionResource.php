<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\ProfessionResource\Pages;
use App\Filament\Clusters\Parameters\Resources\ProfessionResource\RelationManagers;
use App\Models\Parameters\Profession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfessionResource extends Resource
{
    protected static ?string $model = Profession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Profesiones';

    protected static ?string $cluster = Parameters::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('estament_id')
                    ->relationship('estament', 'name')
                    ->label('Estamento')
                    ->required(),
                Forms\Components\Select::make('category')
                    ->label('Categoria')
                    ->options([
                        'A' => 'A (Medicos, Odontologos, Quimicos)',
                        'B' => 'B (Profesionales)',
                        'C' => 'C (Técnicos Nivel Superior)',
                        'D' => 'D (Técnicos Nivel Medio)',
                        'E' => 'E (Administrativos)',
                        'F' => 'F (Auxiliares, Choferes)',
                    ])
                    ->default(null),
                Forms\Components\TextInput::make('sirh_plant')
                    ->label('Planta (SIRH)')
                    ->maxLength(255)
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('sirh_profession')
                    ->label('Profesión (SIRH)')
                    ->maxLength(255)
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estamento')
                    ->label('Estamento')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sirh_plant')
                    ->label('Planta SIRH')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sirh_profession')
                    ->label('Profesión (SIRH)')
                    ->sortable()
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
            ->defaultPaginationPageOption(50);
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
            'index' => Pages\ListProfessions::route('/'),
            'create' => Pages\CreateProfession::route('/create'),
            'edit' => Pages\EditProfession::route('/{record}/edit'),
        ];
    }
}
