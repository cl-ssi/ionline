<?php

namespace App\Filament\Clusters\Finance\Resources;

use App\Filament\Clusters\Finance;
use App\Filament\Clusters\Finance\Resources\AccountancyResource\Pages;
use App\Filament\Clusters\Finance\Resources\AccountancyResource\RelationManagers;
use App\Models\Finance\Accountancy;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountancyResource extends Resource
{
    protected static ?string $model = Accountancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Finance::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('DTE')
                    ->relationship('accountable')
                    ->schema([
                        Forms\Components\Placeholder::make('Dte Id')
                            ->content(fn(Get $get): string => $get('id') ?? ''),
                        Forms\Components\Placeholder::make('Documento')
                            ->content(function(Get $get){
                                $tipo_documento = $get('tipo_documento')?implode('  ', array_map('ucfirst', explode('_', $get('tipo_documento')))):'';                                
                                return new HtmlString('<div>' . $tipo_documento . '<br><small>' . $get('folio') . '</small></div>');
                            }),
                        Forms\Components\Placeholder::make('Emisor')
                            ->content(fn(Get $get) => new HtmlString('<div>' . $get('emisor') . '<br><small>' . $get('razon_social_emisor') . '</small></div>')),
                        Forms\Components\Placeholder::make('Orden de Compra')
                            ->content(function(Model $record) {
                                $out = '';
                                if($record->folio_oc && !$record->purchaseOrder){
                                    $out = $record->folio_oc;
                                } else if($record->folio_oc && $record->purchaseOrder){
                                    $status = $record->purchaseOrder->json->Listado[0]->Estado;
                                    $url = route('finance.purchase-orders.show', $record->purchaseOrder);
                                    $out = new HtmlString('<div><a target="_blank" href="' . $url . '">' . $record->folio_oc . '</a><br><small>' . $status . '</small></div>');
                                }
                                return $out;
                            }),
                    ])
                    ->columns(4)
                    ->visible(fn (Model $record) => $record->accountable_type == 'App\Models\Finance\Dte'),
                Forms\Components\TextInput::make('resolution_folio')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('resolution_date'),
                Forms\Components\TextInput::make('resolution_file')
                    ->maxLength(255),
                Forms\Components\TextInput::make('commitment_folio_sigfe')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('commitment_date_sigfe'),
                Forms\Components\TextInput::make('commitment_file_sigfe')
                    ->maxLength(255),
                Forms\Components\TextInput::make('accrual_folio_sigfe')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('accrual_date_sigfe'),
                Forms\Components\TextInput::make('accrual_file_sigfe')
                    ->maxLength(255),
                Forms\Components\TextInput::make('accountable_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('accountable_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('resolution_folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resolution_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('resolution_file')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commitment_folio_sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commitment_date_sigfe')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('commitment_file_sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accrual_folio_sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accrual_date_sigfe')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accrual_file_sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accountable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accountable_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
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
            'index' => Pages\ListAccountancies::route('/'),
            'create' => Pages\CreateAccountancy::route('/create'),
            'edit' => Pages\EditAccountancy::route('/{record}/edit'),
        ];
    }
}
