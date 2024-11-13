<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Pages;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\RelationManagers;
use App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers\ProcessesRelationManager;
use App\Models\Documents\Agreements\Signer;
use App\Models\Documents\Agreements\Process;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessResource extends Resource
{
    protected static ?string $model = Process::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;
    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $modelLabel = 'proceso';

    protected static ?string $pluralModelLabel = 'procesos';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('process_type_id')
                    ->relationship('processType', 'name')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('period')
                    ->label('Periodo')
                    ->required()
                    ->live()
                    ->options(function () {
                        $currentYear = now()->year;
                        $years       = [];
                        for ($i = 0; $i < 10; $i++) {
                            $years[$currentYear - $i] = $currentYear - $i;
                        }

                        return $years;
                    })
                    ->hiddenOn(ProcessesRelationManager::class),
                Forms\Components\Select::make('program_id')
                    ->label('Programa')
                    ->relationship('program', 'name', fn (Builder $query, callable $get) => $query->where('period', $get('period')))
                    ->hiddenOn(ProcessesRelationManager::class)
                    ->required()
                    ->columnSpan(2),
                Forms\Components\Select::make('commune_id')
                    ->relationship('commune', 'name')
                    ->required(),
                Forms\Components\Select::make('municipality_id')
                    ->relationship('municipality', 'name')
                    ->required(),
                // Forms\Components\TextInput::make('municipality_name')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('municipality_rut')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('municipality_adress')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\Select::make('mayor_id')
                    ->relationship('mayor', 'name')
                    ->required(),
                // Forms\Components\TextInput::make('mayor_name')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('mayor_run')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('mayor_appelative')
                //     ->maxLength(255)
                //     ->default(null),
                // Forms\Components\TextInput::make('mayor_decree')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('number')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('date'),
                Forms\Components\Textarea::make('establishments')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('quotas')
                    ->numeric()
                    ->default(null)
                    ->helperText('Solo para programa de anticipo de aporte estatal'),
                Forms\Components\Select::make('signer_id')
                    ->label('Firmante')
                    ->options(
                        Signer::with('user')->get()->pluck('user.full_name', 'id')
                    )
                    ->required(),
                // Forms\Components\TextInput::make('signer_appellative')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\Textarea::make('signer_decree')
                //     ->required()
                //     ->columnSpanFull(),
                // Forms\Components\TextInput::make('signer_name')
                //     ->required()
                //     ->maxLength(255),


                Forms\Components\Select::make('process_id')
                    ->relationship('process', 'id')
                    ->default(null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('period')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('processType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('commune.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('signer.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('signer_appellative')
                    ->searchable(),
                Tables\Columns\TextColumn::make('signer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('municipality.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('municipality_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('municipality_rut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('municipality_adress')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mayor.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mayor_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mayor_run')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mayor_appelative')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mayor_decree')
                    ->searchable(),
                Tables\Columns\TextColumn::make('process.id')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProcesses::route('/'),
            'create' => Pages\CreateProcess::route('/create'),
            'edit' => Pages\EditProcess::route('/{record}/edit'),
        ];
    }
}
