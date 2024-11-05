<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\Pages;
use App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers;
use App\Models\Parameters\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Convenios';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alias')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('alias_finance')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('financial_type')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('folio')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('subtitle_id')
                    ->relationship('subtitle', 'name')
                    ->required(),
                Forms\Components\TextInput::make('budget')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('period')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('is_program'),
                Forms\Components\Select::make('establishment_id')
                    ->relationship('establishment', 'name')
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alias')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alias_finance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('financial_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('folio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtitle.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('budget')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('period')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_program')
                    ->boolean(),
                Tables\Columns\TextColumn::make('establishment.name')
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
            RelationManagers\ReferersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
