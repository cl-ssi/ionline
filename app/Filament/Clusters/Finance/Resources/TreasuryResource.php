<?php

namespace App\Filament\Clusters\Finance\Resources;

use App\Filament\Clusters\Finance;
use App\Filament\Clusters\Finance\Resources\TreasuryResource\Pages;
use App\Filament\Clusters\Finance\Resources\TreasuryResource\RelationManagers;
use App\Models\Finance\Treasury;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class TreasuryResource extends Resource
{
    protected static ?string $model = Treasury::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Finance::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $modelLabel = 'tesorería';

    protected static ?string $pluralModelLabel = 'tesorerías';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Forms\Components\Fieldset::make('DTE')
                    ->relationship('treasureable')
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
                                    // $out = new HtmlString('<div>' . $record->folio_oc . '<br><small>' . $status . '</small></div>');
                                }
                                return $out;
                            }),
                    ])
                    ->columns(4)
                    ->visible(fn (Model $record) => $record->accountable_type == 'App\Models\Finance\Dte'),                
                Forms\Components\TextInput::make('treasureable_type')
                    ->required()
                    ->hidden()
                    ->maxLength(255),
                Forms\Components\TextInput::make('treasureable_id')
                    ->required()
                    ->hidden()
                    ->numeric(),
                Forms\Components\DatePicker::make('bank_receipt_date')
                    ->label('Fecha Comprobante Bancario'),
                Forms\Components\Group::make()
                    ->relationship('bankReceiptFile')
                    ->columnSpan('full')                    
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipo')
                            ->options(['bank_receipt_file' => 'Documento de Comprobante Bancario'])
                            ->default('bank_receipt_file')
                            ->hidden()
                            ->required(),
                        Forms\Components\FileUpload::make('storage_path')
                            ->label('Archivo')
                            ->directory('ionline/finances/treasuries/support_documents')
                            ->storeFileNamesIn('name')
                            ->acceptedFileTypes(['application/pdf'])
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $set('supportFile.type', 'support_file');
                                }
                            })
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('third_parties_date')
                    ->label('Fecha Terceras Partes'),
                Forms\Components\Group::make()
                    ->relationship('bankReceiptFile')
                    ->label('Comprobante Bancario')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipo')
                            ->options(['third_parties_file' => 'Documento de de Terceras Partes'])
                            ->default('third_parties_file')
                            ->hidden()
                            ->required(),
                        Forms\Components\FileUpload::make('storage_path')
                            ->label('Archivo')
                            ->directory('ionline/finances/treasuries/support_documents')
                            ->storeFileNamesIn('name')
                            ->acceptedFileTypes(['application/pdf'])
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $set('supportFile.type', 'support_file');
                                }
                            })
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('treasureable.modelName')
                    ->label('Asunto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('treasureable.treasuryId')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('treasureable.treasurySubject')
                    ->label('Tipo')
                    ->searchable(),

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
            'index' => Pages\ListTreasuries::route('/'),
            'create' => Pages\CreateTreasury::route('/create'),
            'edit' => Pages\EditTreasury::route('/{record}/edit'),
        ];
    }
}
