<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Drugs\CountersampleDestructionResource\Pages;
use App\Filament\Clusters\Documents\Resources\Drugs\CountersampleDestructionResource\RelationManagers;
use App\Models\Drugs\CountersampleDestruction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountersampleDestructionResource extends Resource
{
    protected static ?string $model = CountersampleDestruction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'destrucción contramuestra';
    
    protected static ?string $pluralModelLabel = 'destrucción contramuestras';
    
    protected static ?string $navigationGroup = 'Drogas';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')
                    ->label('Número')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('destructed_at')
                    ->label('Fecha de destrucción')
                    ->required(),
                Forms\Components\Select::make('court_id')
                    ->label('Juzgado')
                    ->relationship('court', 'name')
                    ->default(null),
                Forms\Components\Select::make('police')
                    ->label('Policía')
                    ->options([
                        'Policía de Investigaciones',
                        'Carabineros de Chile',
                        'Armada de Chile',
                    ])
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Usuario')
                    ->options(fn () => User::all()->pluck('full_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('manager_id')
                    ->label('Encargado')
                    ->options(fn () => User::all()->pluck('full_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('lawyer_id')
                    ->label('Abogado')
                    ->options(fn () => User::all()->pluck('full_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('observer_id')
                    ->label('Observador')
                    ->options(fn () => User::all()->pluck('full_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('lawyer_observer_id')
                    ->label('Abogado observador')
                    ->options(fn () => User::all()->pluck('full_name', 'id'))
                    ->searchable()
                    ->required(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('destructed_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('court.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('police')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('manager.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('lawyer.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('observer.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('lawyerObserver.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\ReceptionItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountersampleDestructions::route('/'),
            'create' => Pages\CreateCountersampleDestruction::route('/create'),
            'edit' => Pages\EditCountersampleDestruction::route('/{record}/edit'),
        ];
    }
}
