<?php

namespace App\Filament\Clusters\Finance\Resources;

use App\Filament\Clusters\Finance;
use App\Filament\Clusters\Finance\Resources\RequestFormResource\Pages;
use App\Filament\Clusters\Finance\Resources\RequestFormResource\RelationManagers;
use App\Models\RequestForms\RequestForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;

class RequestFormResource extends Resource
{
    protected static ?string $model = RequestForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Finance::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $modelLabel = 'Formulario de Compra';

    protected static ?string $pluralModelLabel = 'Formularios de Compra';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('folio')
                    ->maxLength(255),
                Forms\Components\Select::make('purchase_plan_id')
                    ->relationship('purchasePlan', 'id'),
                Forms\Components\TextInput::make('request_form_id')
                    ->numeric(),
                Forms\Components\TextInput::make('request_user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('request_user_ou_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('contract_manager_id')
                    ->relationship('contractManager', 'name')
                    ->required(),
                Forms\Components\TextInput::make('contract_manager_ou_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('name')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('estimated_expense')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('has_increased_expense'),
                Forms\Components\TextInput::make('type_of_currency')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('superior_chief')
                    ->numeric(),
                Forms\Components\TextInput::make('program')
                    ->maxLength(255),
                Forms\Components\TextInput::make('program_id')
                    ->numeric(),
                Forms\Components\Textarea::make('justification')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('type_form')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subtype')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sigfe')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bidding_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('purchase_mechanism_id')
                    ->relationship('purchaseMechanism', 'name')
                    ->required(),
                Forms\Components\Select::make('purchase_unit_id')
                    ->relationship('purchaseUnit', 'name'),
                Forms\Components\Select::make('purchase_type_id')
                    ->relationship('purchaseType', 'name'),
                Forms\Components\TextInput::make('signatures_file_id')
                    ->numeric(),
                Forms\Components\TextInput::make('old_signatures_file_id')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('approved_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                /*
                Tables\Columns\TextColumn::make('purchasePlan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_form_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_user_ou_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contractManager.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_manager_ou_id')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('has_increased_expense')
                    ->boolean(),
                Tables\Columns\TextColumn::make('type_of_currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('superior_chief')
                    ->numeric()
                    ->sortable(),
                */
                Tables\Columns\TextColumn::make('program')
                    ->searchable(),
                Tables\Columns\TextColumn::make('associateProgram.alias_finance')
                    ->numeric()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('estimated_expense')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('itemRequestForms.specification')
                    ->label('Espec')
                    ->searchable()
                    ->wrap()
                    ->bulleted(),
                Tables\Columns\TextColumn::make('itemRequestForms.quantity')
                    ->label('Cantidad')
                    ->searchable()
                    ->bulleted(),
                Tables\Columns\TextColumn::make('itemRequestForms.unit_value')
                    ->label('Espec')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('itemRequestForms.tax')
                    ->label('Impuesto')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('itemRequestForms.expense')
                    ->label('Valor Total')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->bulleted(),
                
                /*
                Tables\Columns\TextColumn::make('type_form')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtype')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bidding_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchaseMechanism.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchaseUnit.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchaseType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('signatures_file_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('old_signatures_file_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime()
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
                */
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRequestForms::route('/'),
            'create' => Pages\CreateRequestForm::route('/create'),
            'edit' => Pages\EditRequestForm::route('/{record}/edit'),
        ];
    }
}
