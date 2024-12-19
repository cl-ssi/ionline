<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\ProgramResource\Pages;
use App\Filament\Clusters\Parameters\Resources\ProgramResource\RelationManagers;
use App\Models\Parameters\Program;
use Filament\Forms;
use Filament\Forms\Components\Group;
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

    protected static ?string $cluster = Parameters::class;

    protected static ?string $navigationGroup = 'Servicio';

    protected static ?string $modelLabel = 'Programa';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        $currentYear = date('Y');
        $years = range($currentYear - 1, $currentYear + 1);

        return $form
            ->schema([
                Forms\Components\Section::make('Programa')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('alias')
                            ->placeholder('Ingresa Alias o Nombre Corto')
                            ->maxLength(50)
                            ->default(null)
                            ->columnSpan(2),
                        Forms\Components\Select::make('period')
                            ->label('Periodo')
                            ->options(array_combine($years, $years))
                            ->default($currentYear),
                        Forms\Components\Toggle::make('is_program')
                            ->label('¿Es programa?'),
                    ])->columns(6),
                Forms\Components\Section::make('Finanzas')
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->label('Descripcion')
                            ->maxLength(255)
                            ->default(null)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('alias_finance')
                            ->label('Nombre en Finanzas')
                            ->maxLength(255)
                            ->default(null)
                            ->columnSpan(2),
                        Forms\Components\Select::make('subtitle_id')
                            ->label('Subt')
                            ->relationship('subtitle', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('financial_type')
                            ->label('Tipo Financiamiento')
                            ->maxLength(50)
                            ->default(null),
                        Forms\Components\TextInput::make('folio')
                            ->numeric()
                            ->placeholder('N° Folio')
                            ->default(null),
                        Forms\Components\TextInput::make('budget')
                            ->label('Presupuesto')
                            ->numeric()
                            ->default(null),
                    ])->columns(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('establishment.name')
                //     ->label('Establecimiento')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('alias')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('alias_finance')
                //     ->label('Alias Finanzas')
                //     ->sortable()
                //     ->searchable(),
                Tables\Columns\TextColumn::make('financial_type')
                    ->label('Financiamiento')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('folio')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('subtitle.name')
                    ->label('Subtitulo')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('')
                //     ->label('Subtitulo')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('budget')
                    ->label('Presupuesto')
                    ->numeric()
                    ->sortable()
                    ->money('CL'),
                Tables\Columns\TextColumn::make('period')
                    ->label('Periodo')
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
                Tables\Filters\SelectFilter::make('period')
                    ->options(range(now()->year - 4, now()->year + 1))
                    ->label('Periodo'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(50)
            ->extremePaginationLinks()
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
