<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Drugs\ReceptionItemResource\Pages;
use App\Filament\Clusters\Documents\Resources\Drugs\ReceptionItemResource\RelationManagers;
use App\Models\Drugs\CountersampleDestruction;
use App\Models\Drugs\Court;
use App\Models\Drugs\ReceptionItem;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceptionItemResource extends Resource
{
    protected static ?string $model = ReceptionItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'item de recepción';

    protected static ?string $pluralModelLabel = 'items de recepción';

    protected static ?string $navigationGroup = 'Drogas';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('substance_id')
                    ->relationship('substance', 'name')
                    ->required(),
                Forms\Components\TextInput::make('nue')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('sample_number')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('document_weight')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('gross_weight')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('net_weight')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('estimated_net_weight')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('sample')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('countersample')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('destruct')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('countersample_destruction_id')
                    ->relationship('countersampleDestruction', 'id')
                    ->default(null),
                Forms\Components\TextInput::make('equivalent')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('reception_id')
                    ->relationship('reception', 'id')
                    ->required(),
                Forms\Components\TextInput::make('result_number')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('result_date'),
                Forms\Components\Select::make('result_substance_id')
                    ->relationship('resultSubstance', 'name')
                    ->default(null),
                Forms\Components\Toggle::make('dispose_precursor'),
                Forms\Components\TextInput::make('countersample_number')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('substance.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nue')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sample_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gross_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('net_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_net_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sample')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('countersample')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('destruct')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('countersampleDestruction.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equivalent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reception.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('result_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('result_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('resultSubstance.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('dispose_precursor')
                    ->boolean(),
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
                Tables\Columns\TextColumn::make('countersample_number')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('create_countersample_destruction')
                        ->form([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\DatePicker::make('destructed_at')
                                    ->label('Fecha de destrucción')
                                    ->required(),
                                Forms\Components\Select::make('court_id')
                                    ->label('Juzgado')
                                    ->options(Court::pluck('name', 'id'))
                                    ->default(null),
                                Forms\Components\Select::make('police')
                                    ->label('Policía')
                                    ->options([
                                        'Policía de Investigaciones' => 'Policía de Investigaciones',
                                        'Carabineros de Chile' => 'Carabineros de Chile',
                                        'Armada de Chile' => 'Armada de Chile',
                                    ])
                                    ->required(),
                                Forms\Components\Select::make('lawyer_id')
                                    ->label('Jurídica')
                                    ->options(User::pluck('full_name', 'id'))
                                    ->searchable('full_name')
                                    ->required(),
                                Forms\Components\Select::make('observer_id')
                                    ->label('Ministro de Fe')
                                    ->options(User::pluck('full_name', 'id'))
                                    ->searchable('full_name')
                                    ->required(),
                                Forms\Components\Select::make('lawyer_observer_id')
                                    ->label('Ministro de Fe Jurídico')
                                    ->options(User::pluck('full_name', 'id'))
                                    ->searchable('full_name')
                                    ->required(),
                            ]),
                        ])
                        ->icon('heroicon-o-fire')
                        ->label('Destrucción contramuestras')
                        ->action(function (array $data, Collection $records): void {
                            $countersampleDestruction = CountersampleDestruction::create([
                                'court_id' => $records->first()->reception->court_id,
                                'police' => '',
                                'destructed_at' => now(),
                                'lawyer_id' => $data['lawyer_id'],
                                'observer_id' => $data['observer_id'],
                                'lawyer_observer_id' => $data['lawyer_observer_id'],
                            ]);
                            $records->each(function (ReceptionItem $record) use ($countersampleDestruction): void {
                                $record->update([
                                    'countersample_destruction_id' => $countersampleDestruction->id,
                                ]);
                            });
                            redirect()->to(CountersampleDestructionResource::getUrl('edit', ['record' => $countersampleDestruction]));
                        }),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (Model $record): bool => is_null($record->countersample_destruction_id),
            );
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
            'index' => Pages\ListReceptionItems::route('/'),
            'create' => Pages\CreateReceptionItem::route('/create'),
            'edit' => Pages\EditReceptionItem::route('/{record}/edit'),
        ];
    }
}
