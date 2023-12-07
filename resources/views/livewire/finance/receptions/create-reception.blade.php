<div>
    <h3 class="mb-3">Crear un acta de recepción conforme</h3>

    <!-- MENU -->
    @include('finance.receptions.partials.nav')

    <!-- Orden de Compra -->
    <div class="row mb-3 g-2">
        <div class="col-md-3">
            <label for="reception-date">Orden de compra</label>
            <div class="input-group">
                <input type="text"
                    class="form-control"
                    placeholder="Orden de compra"
                    aria-label="Orden de compra"
                    aria-describedby="purchase-order"
                    wire:model.defer="purchaseOrderCode">
                <button class="btn btn-primary"
                    wire:click="getPurchaseOrder"
                    wire:loading.attr="disabled">
                    <i class="fa fa-spinner fa-spin"
                        wire:loading></i>
                    <i class="bi bi-search"
                        wire:loading.class="d-none"></i>
                </button>
            </div>
        </div>
        @if ($purchaseOrder)
            <div class="col-md-2 text-center">
                <b>Form. Requerimiento</b><br>
                @if ($purchaseOrder->requestForm)
                    <a href="{{ route('request_forms.show', $purchaseOrder->requestForm->id) }}"
                        target="_blank">
                        {{ $purchaseOrder->requestForm->folio }}
                    </a>
                @else
                    <span class="text-danger">
                        No existe ningún proceso de compra para la OC ingresada. Contácte a abastecimiento.
                    </span>
                @endif
            </div>

            <div class="col-md-2 text-center">
                <b>Orden de Compra</b><br>
                <a target="_blank"
                    href="{{ route('finance.purchase-orders.show', $purchaseOrder) }}">
                    {{ $purchaseOrder->code }}
                </a>
                <br>
                {{ $purchaseOrder->json->Listado[0]->Estado }}
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input"
                        type="checkbox"
                        role="switch"
                        wire:click="togglePoCenabast()"
                        id="for-cenabast"
                        {{ $purchaseOrder->cenabast ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="flexSwitchCheckDefault">Cenabast</label>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <b>Actas creadas para esta OC</b><br>
                <ul>
                    @foreach ($purchaseOrder->receptions as $otherReception)
                        <li>
                            <a href="#">
                                Nº: {{ $otherReception->number }}
                                Fecha: {{ $otherReception->date?->format('Y-m-d') }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-2">
                <b>Documento Tributario*</b><br>
                <ul>
                    @foreach ($purchaseOrder->dtes as $dte)
                        <li>
                            <div class="form-check">
                                <input class="form-check-input @error('selectedDteId') is-invalid @enderror"
                                    type="radio"
                                    wire:model="selectedDteId"
                                    name="selectedDte"
                                    value="{{ $dte->id }}">
                                <label>
                                    {{ $dte->tipoDocumentoIniciales }}
                                    {{ $dte->folio }}
                                </label>
                            </div>
                        </li>
                    @endforeach
                    <li>
                        <div class="form-check">
                            <input class="form-check-input @error('selectedDteId') is-invalid @enderror"
                                type="radio"
                                wire:model="selectedDteId"
                                name="selectedDte"
                                value="0">
                            <label>
                                Otro
                            </label>
                        </div>
                    </li>
                </ul>
                @error('selectedDteId')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @elseif(is_null($purchaseOrder))
            <div class="col-md-3 text-center">
                <br>
                <span class="text-danger">No se encontró la orden de compra</span>
            </div>
        @endif

    </div>


    @if ($purchaseOrder)

        <div class="row mb-3 g-2">
            <div class="col-6">
                <br>
                <h5>Documento Tributario Asociado</h5>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Tipo de documento*</label>
                    <select id="document_type"
                        class="form-select @error('reception.dte_type') is-invalid @enderror"
                        wire:model="reception.dte_type">
                        <option></option>
                        <option value ="guias_despacho">Guía de despacho</option>
                        <option value ="factura_electronica">Factura Electronica Afecta</option>
                        <option value ="factura_exenta">Factura Electronica Exenta</option>
                        <option value ="boleta_honorarios">Boleta Honorarios</option>
                    </select>
                    @error('reception.dte_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Número de documento</label>
                    <input type="text"
                        class="form-control"
                        wire:model.debounce.defer="reception.dte_number">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Fecha de documento</label>
                    <input type="date"
                        class="form-control"
                        wire:model="reception.dte_date">
                </div>
            </div>
        </div>

        <h4>Recepción</h4>

        <div class="row mb-3 g-2">
            <div class="form-group col-md-2">
                <div class="form-group">
                    <label for="number">Número de acta</label>
                    <input type="text"
                        class="form-control"
                        disabled
                        placeholder="Automático">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Fecha acta*</label>
                    <input type="date"
                        class="form-control @error('reception.date') is-invalid @enderror"
                        wire:model="reception.date">
                    @error('reception.date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="form-reception-type">Tipo de acta*</label>
                <select class="form-select @error('reception.reception_type_id') is-invalid @enderror"
                    wire:model="reception.reception_type_id">
                    <option value=""></option>
                    @foreach ($types as $id => $type)
                        <option value="{{ $id }}">{{ $type }}</option>
                    @endforeach
                </select>
                @error('reception.reception_type_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="internal_number">Número interno acta</label>
                    <input type="text"
                        class="form-control"
                        placeholder="opcional"
                        wire:model="reception.internal_number">
                    <div class="form-text">En caso que la unidad tenga su propio correlativo</div>
                </div>
            </div>


        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <Label>Encabezado</Label>
                    <textarea name=""
                        id="for-header_notes"
                        rows="6"
                        class="form-control"
                        wire:model.defer="reception.header_notes"></textarea>

                    <div>
                        @livewire(
                            'text-templates.controls-text-template',
                            [
                                'module' => 'Receptions',
                                'input' => 'reception.header_notes',
                            ],
                            key('head_notes')
                        )
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cantidad / Unidad</th>
                    <th>Especificaciones Comprador</th>
                    <th>Especificaciones Proveedor</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>Cargos</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->json->Listado[0]->Items->Listado as $key => $item)
                    <tr class="{{ $maxItemQuantity[$key] == 0 ? 'table-secondary' : 'table-info' }}">
                        <td class="text-center">
                            {{ $item->CodigoCategoria }}
                        </td>
                        <td>{{ $item->Producto }}</td>
                        <td class="text-center">
                            {{ $item->Cantidad }} {{ $item->Unidad }}
                            <input type="number"
                                class="form-control @error('receptionItems.' . $key . '.Cantidad') is-invalid @enderror"
                                id="quantity"
                                wire:model.debounce.500ms="receptionItems.{{ $key }}.Cantidad"
                                min="1"
                                max="{{ $maxItemQuantity[$key] }}"
                                wire:change="calculateItemTotal({{ $key }})"
                                @disabled($maxItemQuantity[$key] == 0)>
                            <small class="text-secondary"> 0 - {{ $maxItemQuantity[$key] }} </small>
                        </td>
                        <td>{{ $item->EspecificacionComprador }}</td>
                        <td>{{ $item->EspecificacionProveedor }}</td>
                        <td style="text-align: right;">{{ money($item->PrecioNeto) }}</td>
                        <td style="text-align: right;">{{ money($item->TotalDescuentos) }}</td>
                        <td style="text-align: right;">{{ money($item->TotalCargos) }}</td>
                        <td style="text-align: right;">{{ money($item->Cantidad * $item->PrecioNeto) }}</td>
                    </tr>
                    @if (array_key_exists($key, $otherItems))
                        @foreach ($otherItems[$key] as $otherItem)
                            <tr>
                                <td colspan="2">
                                    Acta id: {{ $otherItem['reception_id'] }}
                                </td>
                                <td style="text-align: right;">
                                    {{ $otherItem['Cantidad'] }}
                                </td>
                                <td> recepcionados </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
        @error('receptionItemsWithCantidad')
            <span class="text-danger">{{ $message }}</span>
        @enderror


        <br>
        <br>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('reception.partial_reception') is-invalid @enderror"
                        type="radio"
                        wire:model.defer="reception.partial_reception"
                        id="partial_reception_partial"
                        name="partial_reception"
                        value="1">
                    <label class="form-check-label"
                        for="for-parcial">Recepcionar la OC Parcial</label>
                    <div class="form-text">&nbsp;</div>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('reception.partial_reception') is-invalid @enderror"
                        type="radio"
                        name="partial_reception"
                        wire:model.defer="reception.partial_reception"
                        id="partial_reception_complete"
                        wire:change="setPurchaseOrderCompleted"
                        value="0">
                    <label class="form-check-label"
                        for="for-completa">Recepcionar la OC Completa</label>
                    <div class="form-text">&nbsp;</div>
                </div>
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="for-order_completed"
                        wire:click="togglePoCompleted()"
                        {{ $purchaseOrder->completed ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="flexSwitchCheckDefault">Marcar la Orden de Compra como Completada</label>
                    <div class="form-text">No se recibirán más items de esta Orden de Compra</div>
                </div>
            </div>
            @error('reception.partial_reception')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <Label>Observaciones</Label>
                    <textarea name=""
                        id="for-footer_notes"
                        rows="6"
                        class="form-control"
                        wire:model.defer="reception.footer_notes"></textarea>
                    @livewire(
                        'text-templates.controls-text-template',
                        [
                            'module' => 'Receptions',
                            'input' => 'reception.footer_notes',
                        ],
                        key('footer_notes')
                    )
                </div>
            </div>
        </div>


        <!-- Si tiene otros documentos necesarios para la recepción -->
        @if ($purchaseOrder->requestForm)
            @if ($purchaseOrder->requestForm->paymentDocs)
                <div class="row mb-4">
                    <h4>Adjuntar otros documentos</h4>
                    @foreach ($purchaseOrder->requestForm->paymentDocs as $doc)
                        <div class="col-12">
                            <div class="form-group">
                                <label for="for_{{ $doc->id }}">{{ $doc->name }}</label>
                                <input type="file"
                                    id="for-{{ $doc->id }}"
                                    class="form-control">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif


        <!-- Firmantes -->
        <h4 class="mb-2">Firmantes</h4>
        <div class="row mb-3">
            <div class="col-7">
                <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                @livewire('select-organizational-unit', [
                    'emitToListener' => 'ouSelected',
                    'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
                ])
                <b>Autoridad: </b>
                @if (is_null($authority))
                    <span class="text-danger">La unidad organizacional no tiene una autoridad definida</span>
                @else
                    {{ $authority }}
                @endif
            </div>
            <div class="col-1 text-center">
                <br>
                O
            </div>
            <div class="col">
                <label for="forUsers">Usuario</label>
                @livewire('search-select-user', [], key('firma'))
            </div>
        </div>

        <div class="row text-center">
            <div class="col">
                <b>Columna Izquierda</b>
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-primary form-control"
                            wire:click="addApproval('left')"
                            @disabled(is_null($signer_id) and is_null($signer_ou_id))>
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-success form-control"
                            wire:click="addApproval('left',{{ auth()->id() }})">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>

                @error('approvals')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div style="height: 40px">
                    @if (array_key_exists('left', $this->approvals))
                        {{ $this->approvals['left']['signerShortName'] }}
                        @if (array_key_exists('sent_to_ou_id', $approvals['left']))
                            <i class="fas fa-chess-king"></i>
                        @else
                            <i class="fas fa-chess-pawn"></i>
                        @endif
                        <button class="btn btn-sm btn-danger"
                            wire:click="removeApproval('left')">
                            <i class="bi bi-trash"></i>
                        </button>
                    @endif
                </div>

            </div>

            <div class="col">
                <b>Columna Central</b>
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-primary form-control"
                            wire:click="addApproval('center')"
                            @disabled(is_null($signer_id) and is_null($signer_ou_id))>
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-success form-control"
                            wire:click="addApproval('center',{{ auth()->id() }})">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>

                @error('approvals')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div style="height: 40px">
                    @if (array_key_exists('center', $this->approvals))
                        {{ $this->approvals['center']['signerShortName'] }}
                        @if (array_key_exists('sent_to_ou_id', $approvals['center']))
                            <i class="fas fa-chess-king"></i>
                        @else
                            <i class="fas fa-chess-pawn"></i>
                        @endif
                        <button class="btn btn-sm btn-danger"
                            wire:click="removeApproval('center')">
                            <i class="bi bi-trash"></i>
                        </button>
                    @endif
                </div>
            </div>

            <div class="col">
                <b>Columna Derecha</b>
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-primary form-control"
                            wire:click="addApproval('right')"
                            @disabled(is_null($signer_id) and is_null($signer_ou_id))>
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-success form-control"
                            wire:click="addApproval('right',{{ auth()->id() }})">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>

                @error('approvals')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div style="height: 40px">
                    @if (array_key_exists('right', $this->approvals))
                        {{ $this->approvals['right']['signerShortName'] }}
                        @if (array_key_exists('sent_to_ou_id', $approvals['right']))
                            <i class="fas fa-chess-king"></i>
                        @else
                            <i class="fas fa-chess-pawn"></i>
                        @endif
                        <button class="btn btn-sm btn-danger"
                            wire:click="removeApproval('right')">
                            <i class="bi bi-trash"></i>
                        </button>
                    @endif
                </div>
            </div>

        </div>

        @can('Receptions: load support file')
            <div class="mb-3">
                <label for="support_file"
                    class="form-label">Documento de respaldo</label>
                <input class="form-control"
                    type="file"
                    wire:model="support_file"
                    id="support_file">
            </div>
        @endcan

        @can('Receptions: load file retroactive')
            <div class="alert alert-warning"
                role="alert">
                <h4>Actas firmadas retroactivas. (Sólo para contabilidad)</h4>
                <p>
                    Al adjuntar un archivo en esta sección, no ocurrirá el flujo de firma, ni la numeración.
                    ya que se asumirá que el archivo adjunto fue firmado anteriormente.<br>
                    Debe adjuntar el pdf con el acta firmada, y seleccionar UN SOLO firmante.
                </p>
                <hr>
                <div>
                    <label for="file_signed"
                        class="form-label">Subir acta firmada</label>
                    <input class="form-control"
                        type="file"
                        wire:model="file_signed"
                        id="file_signed">
                </div>
                @error('file_signed')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @endcan



        <hr>




        <!----------------------------------->
        <!-- Preview del acta de recepción -->
        <!----------------------------------->
        <div class="row mb-3">
            <div class="col-9">
                <img src="{{ asset('/images/logo_rgb_' . auth()->user()->organizationalUnit->establishment->alias . '.png') }}"
                    height="109"
                    alt="Logo de la institución">
            </div>
            <div class="col-3 align-self-end fs-5">
                <table class="table">
                    <tr>
                        <th>Número: </th>
                        <td>

                            <i>Autogenerado</i>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Fecha:
                        </th>
                        <td>
                            @if (key_exists('date', $reception))
                                {{ $reception['date'] }}
                            @else
                                <span class="text-danger">Falta la fecha</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <br>

        <h3 class="text-center mb-3">Acta de recepción conforme</h3>

        <p style="white-space: pre-wrap;">{{ $reception['header_notes'] ?? '' }}</p>

        <table class="table table-sm table-bordered">
            <tr>
                <th>
                    Orden de Compra
                </th>
                <td>
                    {{ $reception['purchase_order'] }}
                </td>
                <th>
                    Proveedor
                </th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->Proveedor->Nombre }}
                </td>
                <th>
                    RUT Proveedor
                </th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->Proveedor->RutSucursal }}
                </td>
            </tr>
            <tr>
                <th>
                    N° Documento
                </th>
                <td>
                    {{ $reception['dte_number'] ?? '' }}
                </td>
                <th>
                    Tipo de documento
                </th>
                <td>
                    {{ $reception['dte_type'] ?? '' }}
                </td>
                <th>
                    Fecha Emisón:
                </th>
                <td>
                    {{ $reception['dte_date'] ?? '' }}
                </td>
            </tr>
        </table>

        <table class="table table-sm table-bordered mb-3">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cantidad / Unidad</th>
                    <th>Especificaciones Proveedor</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>Cargos</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receptionItems as $item)
                    @if ($item['Cantidad'])
                        <tr>
                            <td>{{ $item['CodigoCategoria'] }}</td>
                            <td>{{ $item['Producto'] }}</td>
                            <td>{{ $item['Cantidad'] }}</td>
                            <td>{{ $item['EspecificacionProveedor'] }}</td>
                            <td style="text-align: right;">{{ money($item['PrecioNeto']) }}</td>
                            <td style="text-align: right;">{{ money($item['TotalDescuentos']) }}</td>
                            <td style="text-align: right;">{{ money($item['TotalCargos']) }}</td>
                            <td style="text-align: right;">{{ money($item['Total']) }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="6">
                    </td>
                    <td colspan="3">
                        <table>
                            <tr>
                                <th width="100">Neto</th>
                                <td>$</td>
                                <td width="100"
                                    style="text-align: right;">{{ money($reception['neto'] ?? 0) }}</td>
                            </tr>
                            @if (key_exists('descuentos', $reception) and $reception['descuentos'] > 0)
                                <tr>
                                    <th>Dcto.</th>
                                    <td>$</td>
                                    <td style="text-align: right;">{{ money($reception['descuentos'] ?? 0) }}
                                    </td>
                                </tr>
                            @endif
                            @if (key_exists('cargos', $reception) and $reception['cargos'] > 0)
                                <tr>
                                    <th>Cargos</th>
                                    <td>$</td>
                                    <td style="text-align: right;">{{ money($reception['cargos'] ?? 0) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Subtotal</th>
                                <td>$</td>
                                <td style="text-align: right;">{{ money($reception['subtotal'] ?? 0) }}</td>
                            </tr>
                            <tr>
                                <th>{{ $purchaseOrder->json->Listado[0]->PorcentajeIva }}% IVA</th>
                                <td>$</td>
                                <td style="text-align: right;">{{ money($reception['iva'] ?? 0) }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>$</td>
                                <td style="text-align: right;">
                                    <b>{{ money($reception['total'] ?? 0) }}</b>
                                </td>
                            </tr>
                        </table>
                        <b>

                        </b>
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="white-space: pre-wrap;">{{ $reception['footer_notes'] ?? '' }}</p>
        <br>
        <br>
        <br>

        <div class="row text-center mt-3">
            <div class="col">
                @if (array_key_exists('left', $approvals))
                    <b>{{ $this->approvals['left']['signerShortName'] }}</b><br>
                    {{ auth()->user()->organizationalUnit->establishment->name }}<br>
                @endif
            </div>
            <div class="col">
                @if (array_key_exists('center', $approvals))
                    <b>{{ $this->approvals['center']['signerShortName'] }}</b><br>
                    {{ auth()->user()->organizationalUnit->establishment->name }}<br>
                @endif
            </div>
            <div class="col">
                @if (array_key_exists('right', $approvals))
                    <b>{{ $approvals['right']['signerShortName'] }}</b><br>
                    {{ auth()->user()->organizationalUnit->establishment->name }}<br>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6 text-danger">

            </div>
            <div class="col-6 text-end">
                <button class="btn btn-outline-primary"
                    wire:click="preview()">
                    <i class="bi bi-eye"></i>
                    Actualizar previsualización</button>

                <button class="btn btn-primary"
                    wire:click="save"
                    wire:loading.attr="disabled">
                    <i class="fa fa-spinner fa-spin"
                        wire:loading></i>
                    <i class="bi bi-save"
                        wire:loading.class="d-none"></i>
                    Crear
                </button>
            </div>
        </div>

        @include('layouts.bt5.partials.errors')
    @endif
</div>
