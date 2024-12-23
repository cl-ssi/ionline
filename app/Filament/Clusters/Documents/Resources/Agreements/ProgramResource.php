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

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $modelLabel = 'programa';

    protected static ?string $pluralModelLabel = 'programas';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(3),
                Forms\Components\Select::make('period')
                    ->label('Periodo')
                    ->required()
                    ->options(function () {
                        $currentYear = now()->year + 1;
                        $years       = [];
                        for ($i = 0; $i < 10; $i++) {
                            $years[$currentYear - $i] = $currentYear - $i;
                        }

                        return $years;
                    }),
                Forms\Components\TextInput::make('budget')
                    ->label('Presupuesto')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('subtitle_id')
                    ->label('Subtítulo')
                    ->relationship('subtitle', 'name')
                    ->required(),
                // Forms\Components\TextInput::make('alias')
                //     ->maxLength(50)
                //     ->default(null),
                // Forms\Components\TextInput::make('alias_finance')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('financial_type')
                //     ->maxLength(50)
                //     ->default(null),
                // Forms\Components\TextInput::make('folio')
                //     ->numeric()
                //     ->default(null),

                // Forms\Components\DatePicker::make('start_date'),
                // Forms\Components\DatePicker::make('end_date'),
                // Forms\Components\TextInput::make('financial_type')
                //     ->label('Tipo de Financiamiento')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\Toggle::make('is_program'),
                Forms\Components\Fieldset::make('Resolución Ministerial')
                    ->schema([
                        Forms\Components\TextInput::make('ministerial_resolution_number')
                            ->label('Número')
                            ->numeric()
                            ->default(null),
                        Forms\Components\DatePicker::make('ministerial_resolution_date')
                            ->label('Fecha')
                            ->default(null),
                        Forms\Components\FileUpload::make('ministerial_resolution_file')
                            ->directory('ionline/agreements/programs')
                            ->downloadable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(3),
                Forms\Components\Fieldset::make('Resolución de Distribución de Recursos')
                    ->schema([
                        Forms\Components\TextInput::make('resource_distribution_number')
                            ->label('Número')
                            ->numeric()
                            ->default(null),
                        Forms\Components\DatePicker::make('resource_distribution_date')
                            ->label('Fecha')
                            ->default(null),
                        Forms\Components\FileUpload::make('resource_distribution_file')
                            ->downloadable()
                            ->directory('ionline/agreements/programs')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(3),
                // Forms\Components\Select::make('establishment_id')
                //     ->relationship('establishment', 'name')
                //     ->default(null),
                Forms\Components\Toggle::make('is_program')
                    ->label('Es Programa APS'),
            ])
            ->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->wrap()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('alias')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('alias_finance')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('financial_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('folio')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('subtitle.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('budget')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('period')
                    ->label('Periodo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ministerial_resolution_number')
                    ->label('Reso Minsal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ministerial_resolution_date')
                    ->label('Fecha Reso Minsal')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('resource_distribution_number')
                    ->label('Reso Distribución')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resource_distribution_date')
                    ->label('Fecha Reso Distribución')
                    ->date('Y-m-d')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('establishment.name')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('referers.full_name')
                    ->label('Referentes')
                    ->wrap()
                    ->bulleted()
                    ->searchable(['full_name'])
                    ->sortable(['full_name'])
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
                Tables\Filters\Filter::make('is_program')
                    ->query(fn (Builder $query): Builder => $query->where('is_program', true))
                    ->label('Es Programa APS')
                    ->default(true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
        // ->modifyQueryUsing(function ($query) {
        //     $query->where('is_program', true);
        // });
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProcessesRelationManager::class,
            RelationManagers\CdpsRelationManager::class,
            RelationManagers\ComponentsRelationManager::class,
            RelationManagers\ReferersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit'   => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
