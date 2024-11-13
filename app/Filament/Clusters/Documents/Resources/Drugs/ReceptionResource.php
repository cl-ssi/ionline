<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Drugs\ReceptionResource\Pages;
use App\Filament\Clusters\Documents\Resources\Drugs\ReceptionResource\RelationManagers;
use App\Models\Drugs\Reception;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceptionResource extends Resource
{
    protected static ?string $model = Reception::class;

    protected static ?string $navigationIcon = 'fas-cannabis';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'recepción';

    protected static ?string $pluralModelLabel = 'recepciones';

    protected static ?string $navigationGroup = 'Drogas';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('parte_label')
                    ->label('Tipo')
                    ->inline()
                    ->inlineLabel(false)
                    ->options([
                        'Parte' => 'Parte',
                        'Oficio Reservado' => 'Oficio Reservado',
                        'RUC' => 'RUC',
                    ])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('parte')
                    ->label('Parte/Of.Res/RUC')
                    ->required()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('parte_police_unit_id')
                    ->label('Origen')
                    ->relationship('partePoliceUnit', 'name')
                    ->required()
                    ->columnSpan(2),
                Forms\Components\Select::make('court_id')
                    ->label('Fiscalia')
                    ->relationship('court', 'name')
                    ->required()
                    ->columnSpan(2),
                Forms\Components\TextInput::make('document_number')
                    ->required()
                    ->label(label: 'Número Oficio')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('document_police_unit_id')
                    ->label(label: 'Origen Oficio')
                    ->relationship('documentPoliceUnit', 'name')
                    ->required()
                    ->columnSpan(2),
                Forms\Components\DatePicker::make('document_date')
                    ->label(label: 'Fecha Oficio')
                    ->required(),
                Forms\Components\TextInput::make('delivery')
                    ->maxLength(255)
                    ->label(label: 'Funcionario que Entrega')
                    ->default(null)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('delivery_run')
                    ->maxLength(255)
                    ->label('RUN Funcionario')
                    ->default(null),
                Forms\Components\TextInput::make('delivery_position')
                    ->maxLength(255)
                    ->label('Cargo de quien entrega')
                    ->default(null)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('inputed')
                    ->maxLength(255)
                    ->label('Nombre Imputado')
                    ->columnSpan(2)
                    ->default(null),
                Forms\Components\TextInput::make('imputed_run')
                    ->maxLength(255)
                    ->label('RUN Imputado')
                    ->default(null),
                Forms\Components\TextInput::make('observation')
                    ->label('Observación')
                    ->columnSpanFull(),

                Forms\Components\Hidden::make('user_id')->default(fn() => auth()->id()),
            ])
            ->columns(5);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('N.Acta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('d-m-Y')
                    ->label('Fecha Acta')
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_number')
                    ->label('N° Doc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('documentPoliceUnit.name')
                    ->numeric()
                    ->wrap()
                    ->label('Origen Oficio')
                    ->sortable(),
                Tables\Columns\TextColumn::make('partePoliceUnit.name')
                    ->numeric()
                    ->wrap()
                    ->label('Origen Parte')
                    ->sortable(),
                Tables\Columns\TextColumn::make('items')
                    ->getStateUsing(function ($record) {
                        return count($record->items);
                    })
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
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('reception')
                    ->icon('heroicon-s-document-check')
                    ->hiddenLabel()
                    ->color('success')
                    ->url(fn(Reception $record): string => route('drugs.receptions.record', $record))
                    ->openUrlInNewTab()
                    ->visible(fn(Reception $record): bool => $record->items->isNotEmpty()),
                Tables\Actions\Action::make('destruction')
                    ->icon('heroicon-s-document-minus')
                    ->hiddenLabel()
                    ->color('danger')
                    ->url(fn(Reception $record): string => route('drugs.destructions.show', $record))
                    ->openUrlInNewTab()
                    ->hidden(fn(Reception $record): bool => is_null($record->destruction) ),
                Tables\Actions\Action::make('destruction')
                    ->color('warning')
                    ->label(fn(Reception $record): string => (int) $record->date->diffInDays(now()) - 15)
                    ->visible(fn(Reception $record): bool => !$record->haveItemsForDestruction->isEmpty() AND is_null($record->destruction)),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReceptions::route('/'),
            'create' => Pages\CreateReception::route('/create'),
            'edit' => Pages\EditReception::route('/{record}/edit'),
        ];
    }
}
