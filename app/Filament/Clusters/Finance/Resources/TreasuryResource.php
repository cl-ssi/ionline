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
                Forms\Components\Fieldset::make('Viaticos')
                    ->relationship('treasureable')
                    ->schema([
                        Forms\Components\Placeholder::make('Dte Id')
                            ->content(fn(Get $get): string => $get('id') ?? ''),
                        Forms\Components\Placeholder::make('Tipo de Documento')
                            ->content(fn(Get $get): string => $get('tipo_documento') ?? ''),
                        Forms\Components\Placeholder::make('Razon Social')
                            ->content(fn(Get $get): string => $get('razon_social_emisor') ?? ''),
                        // Forms\Components\Placeholder::make('Emisor')
                        //     ->content(fn(Model $record): string => ($record->) ?? ''),
                        Forms\Components\Placeholder::make('Orden de Compra')
                            ->content(fn(Model $record): string => $record->folio_oc?(!$record->purchaseOrder?$record->folio_oc:$record->folio_oc . ' ('. $record->purchaseOrder->json->Listado[0]->Estado . ')'):''  ),
                        Forms\Components\Placeholder::make('Folio Compromiso Sigfe')
                            ->content(fn(Get $get): string => $get('folio_compromiso_sigfe') ?? ''),
                        Forms\Components\Placeholder::make('Archivo Compromiso Sigfe')                        
                            ->content(fn(Model $record) => ($record->archivo_compromiso_sigfe)?(new HtmlString('<a href="' . Storage::disk()->url($record->archivo_compromiso_sigfe) . '"   target="_blank">Descargar</a>')):''),
                        Forms\Components\Placeholder::make('Folio Devengo Sigfe')
                            ->content(fn(Get $get): string => $get('folio_devengo_sigfe') ?? ''),
                        Forms\Components\Placeholder::make('Archivo Devengo Sigfe')                        
                            ->content(fn(Model $record) => ($record->archivo_devengo_sigfe)?(new HtmlString('<a href="' . Storage::disk()->url($record->archivo_devengo_sigfe) . '"   target="_blank">Descargar</a>')):''),  
                    ])
                    ->columns(4)
                    ->visible(fn (Model $record) => false),
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
                Forms\Components\Placeholder::make('bank_receipt_file')
                    ->hidden(fn(Model $record)=>is_null($record->bankReceiptFile?->storage_path))
                    ->content(fn(Model $record, Get $get) => ($record->bankReceiptFile?->storage_path)?(new HtmlString('<a href="' . Storage::disk()->url($record->bankReceiptFile?->storage_path) . '"   target="_blank">' . $get('bank_receipt_file') . '</a>')):''),
                Forms\Components\FileUpload::make('bankReceiptFile')
                    ->visible(fn(Model $record)=>is_null($record->bankReceiptFile?->storage_path))
                    ->label('Comprobante Bancario')
                    ->directory('ionline/finances/treasuries/support_documents')
                    ->storeFileNamesIn('bank_receipt_file')
                    ->acceptedFileTypes(['application/pdf']),
                Forms\Components\DatePicker::make('third_parties_date')
                    ->label('Fecha Terceras Partes'),
                Forms\Components\Placeholder::make('third_parties_file')
                    ->hidden(fn(Model $record)=>is_null($record->thirdPartiesFile?->storage_path))
                    ->content(fn(Model $record, Get $get) => ($record->thirdPartiesFile?->storage_path)?(new HtmlString('<a href="' . Storage::disk()->url($record->thirdPartiesFile?->storage_path) . '"   target="_blank">' . $get('third_parties_file') . '</a>')):''),
                Forms\Components\FileUpload::make('thirdPartiesFile')
                    ->visible(fn(Model $record)=>is_null($record->thirdPartiesFile?->storage_path))
                    ->label('Archivo de Terceras Partes')
                    ->directory('ionline/finances/treasuries/support_documents')
                    ->storeFileNamesIn('third_parties_file')
                    ->acceptedFileTypes(['application/pdf']),
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
