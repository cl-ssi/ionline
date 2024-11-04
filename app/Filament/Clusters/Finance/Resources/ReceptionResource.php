<?php

namespace App\Filament\Clusters\Finance\Resources;

use App\Filament\Clusters\Finance;
use App\Filament\Clusters\Finance\Resources\ReceptionResource\Pages;
use App\Models\Establishment;
use App\Models\Finance\PurchaseOrder;
use App\Models\Finance\Receptions\Reception;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\WebService\MercadoPublico;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReceptionResource extends Resource
{
    protected static ?string $model = Reception::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Finance::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $modelLabel = 'Recepción';

    protected static ?string $pluralModelLabel = 'Recepciones';

    public function mount() {}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //1057448-706-SE24
                //1272565-444-AG23

                Forms\Components\TextInput::make('purchase_order')
                    ->hiddenLabel(true)
                    ->maxLength(255)
                    ->placeholder('Orden de Compra')
                    ->columnSpan(2),
                // ->helperText('1272565-444-AG23'),
                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('Buscar')
                        ->action(function (Get $get, Set $set) {
                            $globalPurchaseOrder = PurchaseOrder::with(['requestForm', 'receptions', 'dtes'])
                                ->where('code', $get('purchase_order'))
                                ->first();

                            if (! $globalPurchaseOrder) {
                                $status = MercadoPublico::getPurchaseOrderV2($get('purchase_order'));
                                if ($status === true) {
                                    $globalPurchaseOrder = PurchaseOrder::with(['requestForm', 'receptions', 'dtes'])
                                        ->where('code', $get('purchase_order'))
                                        ->first();
                                } else {
                                    // Manejar el error si no se pudo obtener la orden de compra
                                    // Por ejemplo, puedes lanzar una excepción o establecer un mensaje de error
                                    $set('searchOcMessage', $status);
                                }
                            }
                            // Almacenar la orden de compra en una variable de estado
                            $set('globalPurchaseOrder', $globalPurchaseOrder);
                        }),
                ]),
                Forms\Components\Placeholder::make('searchOcMessage')
                    ->hiddenLabel(true)
                    ->columnSpan(2)
                    ->content(fn (Get $get) => $get('searchOcMessage') ?? null),

                Forms\Components\Section::make('Información de la orden de compra')
                    ->schema([
                        Forms\Components\Placeholder::make('FR')
                            ->label('FR')
                            ->content(function (Get $get): string {
                                $purchaseOrder = $get('globalPurchaseOrder');

                                return $purchaseOrder->requestForm->folio ?? 'No existe ningún proceso de compra para la OC ingresada. Contácte a abastecimiento.';
                            }),

                        Forms\Components\Placeholder::make('Orden de compra')
                            ->label('Orden de compra')
                            ->content(function (Get $get): string {
                                $purchaseOrder = $get('globalPurchaseOrder');
                                if ($purchaseOrder) {
                                    return $purchaseOrder->code;
                                }

                                return 'No se encontró la OC';
                            }),

                        Forms\Components\Placeholder::make('Actas creadas')
                            ->label('Actas creadas para esta OC')
                            ->content(function (Get $get): string {
                                $purchaseOrder = $get('globalPurchaseOrder');
                                if ($purchaseOrder && ! $purchaseOrder->receptions->isEmpty()) {
                                    return $purchaseOrder->receptions->map(function ($reception) {
                                        return $reception->id.': '.$reception->description;
                                    })->implode("\n");
                                } else {
                                    return 'No se encontraron actas creadas para esta OC.';
                                }
                            }),
                    ])
                    ->columns(3)
                    ->visible(fn (Get $get) => $get('globalPurchaseOrder') instanceof PurchaseOrder),

                Forms\Components\Section::make('Documento tributario electrónico')
                    ->schema([
                        Forms\Components\Radio::make('dte_id')
                            ->label('Folio')
                            ->options(fn (Get $get) => $get('globalPurchaseOrder')->dtes->pluck('folio', 'id'))
                            ->descriptions(fn (Get $get) => $get('globalPurchaseOrder')->dtes->pluck('tipo_documento', 'id'))
                            ->live()
                            ->afterStateUpdated(function ($state, $set, Get $get) {
                                $dte = $get('globalPurchaseOrder')->dtes->where('id', $state)->first();
                                if ($dte) {
                                    $set('dte_type', $dte->tipo_documento);
                                    $set('dte_number', $dte->folio);
                                    $set('dte_date', $dte->emision->format('Y-m-d'));
                                }
                            }),
                        Forms\Components\Select::make('dte_type')
                            ->label('Tipo')
                            ->options([
                                'boleta_honorarios'   => 'Boleta Honorarios',
                                'factura_electronica' => 'Factura Electronica Afecta',
                                'factura_exenta'      => 'Factura Electronica Exenta',
                                'guias_despacho'      => 'Guía de despacho',
                                'orden_trabajo'       => 'Orden de Trabajo',
                            ])
                            ->required()
                            ->default(null),
                        Forms\Components\TextInput::make('dte_number')
                            ->label('Número')
                            ->maxLength(255)
                            ->required()
                            ->default(null),
                        Forms\Components\DatePicker::make('dte_date')
                            ->label('Fecha de emisión')
                            ->required(),
                    ])
                    ->columns(4)
                    ->visible(fn (Get $get) => $get('globalPurchaseOrder') instanceof PurchaseOrder),

                Forms\Components\Section::make('Acta de recepción')
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label('Número')
                            ->disabled()
                            ->placeholder('Automático'),
                        Forms\Components\DatePicker::make('date')
                            ->label('Fecha')
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('reception_type_id')
                            ->label('Tipo')
                            ->relationship(
                                name: 'receptionType',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('establishment_id', auth()->user()->organizationalUnit->establishment_id),
                            )
                            ->required(),
                        Forms\Components\TextInput::make('internal_number')
                            ->label('Número interno')
                            ->maxLength(255)
                            ->default(null)
                            ->helperText('En caso que la unidad tenga su propio correlativo'),

                        Forms\Components\Textarea::make('header_notes')
                            ->label('Encabezado')
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('Producto')
                                    ->required()
                                    ->columnSpan(4),
                                Forms\Components\TextInput::make('Cantidad')
                                    ->required()
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                        $cantidad   = $state;
                                        $precioNeto = $get('PrecioNeto');
                                        $set('Total', $cantidad * $precioNeto);
                                        self::updateTotals($set, $get);
                                    }),
                                Forms\Components\TextInput::make('PrecioNeto')
                                    ->required()
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                        $precioNeto = $state;
                                        $cantidad   = $get('Cantidad');
                                        $set('Total', $cantidad * $precioNeto);
                                        self::updateTotals($set, $get);
                                    }),
                                Forms\Components\TextInput::make('Total')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),
                                Forms\Components\Hidden::make('Unidad')
                                    ->default('Unidad')
                                    ->required(),
                            ])
                            ->orderColumn('item_position')
                            ->columns(7)
                            // ->live()
                            ->defaultItems(1)
                            ->minItems(1)
                            ->columnSpanFull(),

                        Forms\Components\Split::make([
                            Forms\Components\Section::make([
                                Forms\Components\Radio::make('partial_reception')
                                    ->label('Recepción parcial')
                                    ->boolean()
                                    ->inline()
                                    ->required()
                                    ->inlineLabel(false),
                                Forms\Components\Toggle::make('purchaseOrder_completed')
                                    ->label('Orden de compra completada')
                                    ->helperText('No se recibirán más items de esta OC'),
                                Forms\Components\Textarea::make('footer_notes')
                                    ->label('Notas finales')
                                    ->columnSpanFull(),
                            ]),
                            Forms\Components\Section::make([
                                Forms\Components\TextInput::make('neto')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(),
                                Forms\Components\TextInput::make('descuentos')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                                Forms\Components\TextInput::make('cargos')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                                Forms\Components\TextInput::make('subtotal')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(),
                                Forms\Components\TextInput::make('iva')
                                    ->label(fn (Get $get) => 'IVA ('.$get('globalPurchaseOrder')->iva.'%)')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(),
                                Forms\Components\TextInput::make('total'),
                            ])->grow(false),
                        ])->columnSpanFull(),

                        Forms\Components\Repeater::make('SupportFile')
                            ->relationship('supportFile')
                            ->label('Archivo')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('Tipo')
                                    ->options(['support_file' => 'Documento de soporte'])
                                    ->required(),
                                Forms\Components\FileUpload::make('storage_path')
                                    ->label('Archivo')
                                    ->directory('ionline/finances/receptions/support_documents')
                                    ->storeFileNamesIn('name')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state) {
                                            $set('supportFile.type', 'support_file');
                                        }
                                    })
                                    ->required(),
                            ])
                            ->defaultItems(0)
                            ->columns(2)
                            ->maxItems(1)
                            ->columnSpanFull(),

                    ])
                    ->columns(4)
                    ->visible(fn (Get $get) => $get('globalPurchaseOrder') instanceof PurchaseOrder),

                Forms\Components\Section::make('Firmas')
                    ->schema([
                        Forms\Components\Repeater::make('approvals')
                            ->hiddenLabel()
                            ->relationship('approvals')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Hidden::make('position')
                                            ->default(fn (Get $get) => match (count($get('../../approvals'))) {
                                                1       => 'left',
                                                2       => 'center',
                                                3       => 'right',
                                                default => 'left', // Puedes cambiar 'default_value' por el valor que desees para otros casos
                                            }),
                                        Forms\Components\Select::make('establishment_id')
                                            ->label('Establecimiento')
                                            ->options(Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
                                            ->default(auth()->user()->establishment_id)
                                            ->live(),
                                        SelectTree::make('sent_to_ou_id')
                                            ->label('Unidad Organizacional')
                                            ->relationship(
                                                relationship: 'sentToOu',
                                                titleAttribute: 'name',
                                                parentAttribute: 'organizational_unit_id',
                                                modifyQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name'),
                                                modifyChildQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name')
                                            )
                                            ->searchable()
                                            ->parentNullValue(null)
                                            ->enableBranchNode()
                                            ->defaultOpenLevel(1)
                                            ->columnSpan(2)
                                            ->live(),
                                        Forms\Components\Section::make()
                                            ->description('O enviar a un usuario específico')
                                            ->schema([
                                                Forms\Components\Select::make('sent_to_user_id')
                                                    ->relationship('sentToUser', 'full_name')
                                                    ->label('Usuario (solo para casos en no sea una jefatura)')
                                                    ->searchable()
                                                    ->columnSpanFull(),
                                            ])
                                            ->collapsed()
                                            ->compact(),
                                    ]),
                            ])
                            ->afterStateUpdated(function ($state, Set $set) {
                                // Reasignar posiciones para los elementos restantes
                                foreach ($state as $index => &$approval) {
                                    if ($index === 0) {
                                        $approval['position'] = 'left';
                                    } elseif ($index === 1) {
                                        $approval['position'] = 'center';
                                    } elseif ($index === 2) {
                                        $approval['position'] = 'right';
                                    }
                                }
                                // Actualizar el estado de los ítems en el Repeater
                                $set('approvals', $state);
                            })
                            ->itemLabel(fn (array $state): ?string => 'Firmante: '.OrganizationalUnit::find($state['sent_to_ou_id'])?->manager?->short_name ?? null)
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                // TODO: Averiguar si se puede acceder al record, para usar la relacion en vez de hacer la queery a OUs
                                $data['establishment_id'] = OrganizationalUnit::find($data['sent_to_ou_id'])?->establishment_id;

                                return $data;
                            })
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Get $get): array {
                                $data['module']              = 'Recepcion';
                                $data['module_icon']         = 'fas fa-list';
                                $data['subject']             = 'Acta de recepción conforme';
                                $data['document_route_name'] = 'finance.receptions.show';

                                return $data;
                            })
                            ->maxItems(3),
                    ])
                    ->visible(fn (Get $get) => $get('globalPurchaseOrder') instanceof PurchaseOrder),

                // Forms\Components\Select::make('guia_id')
                //     ->relationship('guia', 'id')
                //     ->default(null),
                // Forms\Components\Toggle::make('status'),
                // Forms\Components\Toggle::make('mercado_publico'),
                // Forms\Components\Select::make('responsable_id')
                //     ->relationship('responsable', 'name')
                //     ->default(null),
                // Forms\Components\Select::make('responsable_ou_id')
                //     ->relationship('responsableOu', 'name')
                //     ->default(null),
                // Forms\Components\Select::make('creator_id')
                //     ->relationship('creator', 'name')
                //     ->required(),
                // Forms\Components\Select::make('creator_ou_id')
                //     ->relationship('creatorOu', 'name')
                //     ->required(),
                // Forms\Components\Select::make('establishment_id')
                //     ->relationship('establishment', 'name')
                //     ->required(),
            ])
            ->columns(7);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_order')
                    ->label('Orden de compra')
                    ->url(fn (Reception $record) => $record->purchaseOrder ? route('finance.purchase-orders.show', $record->purchaseOrder) : null)
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchaseOrder.provider')
                    ->label('Proveedor')
                    ->wrap(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('responsable.shortName')
                    ->numeric()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\IconColumn::make('mercado_publico')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approvals.id')
                    ->bulleted(),
                // Tables\Columns\TextColumn::make('number')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('internal_number')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('receptionType.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('guia.id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('dte.id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('dte_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('dte_number')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('dte_date')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('rejected')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('partial_reception')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('neto')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('descuentos')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('cargos')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('subtotal')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('iva')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('status')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('responsableOu.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('creator.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('creatorOu.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('establishment.name')
                //     ->numeric()
                //     ->sortable(),
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
            ])
            ->defaultSort('id', 'desc');
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
            'index'  => Pages\ListReceptions::route('/'),
            'create' => Pages\CreateReception::route('/create'),
            'edit'   => Pages\EditReception::route('/{record}/edit'),
        ];
    }

    protected static function updateTotals(Set $set, Get $get)
    {
        $items = $get('../../items');
        $neto  = array_reduce($items, function ($carry, $item) {
            $cantidad   = $item['Cantidad'] ?? 0;
            $precioNeto = $item['PrecioNeto'] ?? 0;

            return $carry + ($cantidad * $precioNeto);
        }, 0);
        $set('../../neto', $neto);

        $descuentos = $get('../../descuentos') ?? 0;
        $cargos     = $get('../../cargos') ?? 0;
        $subtotal   = $neto - $descuentos + $cargos;
        $set('../../subtotal', $subtotal);

        $globalPurchaseOrder = $get('../../globalPurchaseOrder');
        $iva                 = $subtotal * $globalPurchaseOrder->iva / 100;
        $set('../../iva', $iva);

        $total = $subtotal + $iva;
        $set('../../total', $total);
    }
}
