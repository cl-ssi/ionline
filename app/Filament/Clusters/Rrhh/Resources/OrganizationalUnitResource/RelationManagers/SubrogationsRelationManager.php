<?php

namespace App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\RelationManagers;

use App\Enums\Rrhh\AuthorityType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubrogationsRelationManager extends RelationManager
{
    protected static string $relationship = 'subrogations';

    protected static ?string $title = 'Línea de subrogancia';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'full_name')
                    ->label('Usuario')
                    ->searchable()
                    ->required()
                    ->columnSpan(6),
                // Forms\Components\Select::make('subrogant_id')
                //     ->relationship('subrogant', 'name')
                //     ->required(),
                Forms\Components\Select::make('level')
                    ->required()
                    ->label('Nivel de jeraquía')
                    ->options(
                        collect(range(1, 10))
                            ->mapWithKeys(fn ($level) => [$level => $level])
                            ->toArray()
                    )
                    ->columnSpan(2),
                // Forms\Components\Select::make('organizational_unit_id')
                //     ->relationship('organizationalUnit', 'name')
                //     ->default(null),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options(AuthorityType::class)
                    ->required()
                    ->columnSpan(4),
                // Forms\Components\Toggle::make('active')
                //     ->required(),
            ])
            ->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('level')
                    ->label('Nivel de jeraquía')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.shortName')
                    ->label('Usuario')
                    ->sortable(['full_name'])
                    ->searchable(['full_name']),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable(),
                // Tables\Columns\IconColumn::make('deactivated')
                //     ->boolean(),
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
                Tables\Filters\SelectFilter::make('type')
                    ->label(label: 'Tipo')
                    ->options(AuthorityType::class)
                    ->default('manager'),
            ], layout: FiltersLayout::AboveContent)
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
            ])
            ->defaultSort('type', 'asc')
            ->defaultSort('level', 'asc')
            ->reorderable('level')
            ->defaultGroup('type');
    }
}
