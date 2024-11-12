<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource\Pages;
use App\Models\Drugs\Substance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

class SubstancesResource extends Resource
{
    protected static ?string $model = Substance::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'sustancia';

    protected static ?string $pluralModelLabel = 'sustancias';

    protected static ?string $navigationGroup = 'Drogas';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('presumed')
                    ->label('Sustancia Presunta')
                    ->live()
                    ->helperText('La sustancia presunta se utiliza en una recepción, de lo contrario es una sustancia determinada por el resultado de un laboratorio.')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('rama')
                    ->label('Rama')
                    ->options([
                        'Alucinógenos' => 'Alucinógenos',
                        'Estimulantes' => 'Estimulantes',
                        'Depresores'   => 'Depresores',
                        'Precursores'  => 'Precursores',
                    ])
                    ->default(fn ($state) => match ($state) {
                        'Alucinógenos' => 'Alucinógenos',
                        'Estimulantes' => 'Estimulantes',
                        'Depresores'   => 'Depresores',
                        'Precursores'  => 'Precursores',
                        default        => '',
                    }),
                Forms\Components\Select::make('unit')
                    ->label('Unidad')
                    ->options([
                        'Ampollas'   => 'Ampollas',
                        'Gramos'     => 'Gramos',
                        'Mililitros' => 'Mililitros',
                        'Unidades'   => 'Unidades',
                    ])
                    ->default(fn ($state) => match ($state) {
                        'Ampollas'   => 'Ampollas',
                        'Gramos'     => 'Gramos',
                        'Mililitros' => 'Mililitros',
                        'Unidades'   => 'Unidades',
                        default      => '',
                    }),
                Forms\Components\Select::make('laboratory')
                    ->label('Laboratorio')
                    ->options([
                        'SEREMI' => 'SEREMI',
                        'ISP'    => 'ISP',
                    ])
                    ->default(fn ($state) => match ($state) {
                        'SEREMI' => 'SEREMI',
                        'ISP'    => 'ISP',
                        default  => '',
                    }),
                Forms\Components\Select::make('result_id')
                    ->label('Resultado')
                    ->helperText('Selecciona el resultado de laboratorio que corresponde a esta sustancia presunta.')
                    ->options(Substance::where('presumed', false)->pluck('name', 'id'))
                    ->searchable()
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('presumed') == true),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('presumed')
                    ->boolean()
                    ->sortable()
                    ->label('Presunta'),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label('Nombre')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rama')
                    ->sortable()
                    ->label('Rama')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('unit')
                    ->sortable()
                    ->label('Unidad')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('laboratory')
                    ->sortable()
                    ->label('Laboratorio')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('result.name')
                    ->sortable()
                    ->label('Resultado')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('presumed')
                    ->label('Presunta'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
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
            'index'              => Pages\ListSubstances::route('/'),
            'create'             => Pages\CreateSubstances::route('/create'),
            'edit'               => Pages\EditSubstances::route('/{record}/edit'),
            'report-confiscated' => Pages\ReportConfiscated::route('/report-confiscated'),
        ];
    }
}
