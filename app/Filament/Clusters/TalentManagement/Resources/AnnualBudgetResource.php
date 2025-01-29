<?php

namespace App\Filament\Clusters\TalentManagement\Resources;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\AnnualBudgetResource\Pages;
use App\Filament\Clusters\TalentManagement\Resources\AnnualBudgetResource\RelationManagers;
use App\Models\IdentifyNeeds\AnnualBudget;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;
use Filament\Forms\Components\Grid;

class AnnualBudgetResource extends Resource
{
    protected static ?string $model = AnnualBudget::class;

    protected static ?string $modelLabel = 'Presupuestos';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = TalentManagement::class;

    protected static ?string $navigationGroup = 'DNC';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('DNC: annual budget') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)->schema([
                    Forms\Components\Select::make('period')
                        ->label('Periodo (año)')
                        ->options([
                            '2025'  => '2025', 
                        ])
                        ->preload()
                        ->columnSpan(6)
                        ->required(),
                    Forms\Components\Select::make('law')
                        ->label('Ley N°')
                        ->options([
                            '18843'  => '18.843',
                            '19664'  => '19.664', 
                        ])
                        ->preload()
                        ->columnSpan(6)
                        ->required(),
                    Forms\Components\Select::make('item')
                        ->label('Item')
                        ->options([
                            'red asistencial'   => 'Red Asistencial',
                            'dss'               => 'Dirección Servicio de Salud',
                        ])
                        ->preload()
                        ->columnSpan(6)
                        ->required(),
                    Forms\Components\TextInput::make('budget')
                        ->label('Presupuesto')
                        ->numeric()
                        ->minValue(1)
                        ->columnSpan(6)
                        ->required(),
                    Forms\Components\Select::make('establishment_id')
                        ->label('Establecimiento')
                        ->relationship('establishment', 'name')
                        ->default(fn () => auth()->user()->establishment_id)
                        ->preload()
                        ->columnSpanFull()
                        ->disabled()
                        ->dehydrated()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('law')
                    ->label('Ley N°')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('item_value')
                    ->label('Item')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('budget')
                    ->label('Presupuesto')
                    ->getStateUsing(fn ($record) => number_format($record->budget, 0, ',', '.') . ' CLP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('establishment.name')
                    ->label('Establecimiento')
                    ->sortable()
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnualBudgets::route('/'),
            'create' => Pages\CreateAnnualBudget::route('/create'),
            'edit' => Pages\EditAnnualBudget::route('/{record}/edit'),
        ];
    }
}
