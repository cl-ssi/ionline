<div>
    <h3 class="mb-3">Crear un acta de recepción conforme sin OC</h3>

    <!-- MENU -->
    @include('finance.receptions.partials.nav')


    <h5>Documento Tributario Asociado</h5>
    <!-- Archivo Digitalizado de DTE -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
    @endif



    <div class="row mb-3 g-2">

        <div class="col-md-4">
            <!-- Etiqueta y campo de carga de archivo -->
            <label for="digital-invoice-file">Archivo Digitalizado DTE</label>
            <div class="input-group">
                <input type="file"
                class="form-control"
                placeholder="Archivo Digitalizado DTE"
                aria-label="Archivo Digitalizado DTE"
                aria-describedby="digital-invoice"
                wire:model="digitalInvoiceFile">
            </div>
            @error('digitalInvoiceFile')
                    <span class="text-danger">{{ $message }}</span>
            @enderror

            <i class="fa fa-spinner fa-spin"
                        wire:loading></i>
        </div>

    

        <div class="form-group col-2">
            <label for="emisor">RUT*</label>
            <input type="text" class="form-control" id="emisor" wire:model.live="emisor"
                autocomplete="off"
                wire:loading.attr="disabled"
                wire:target="digitalInvoiceFile"
                wire:change="loadDteData()"
                >
            @error('emisor')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="reception-date">Tipo de documento*</label>
                <select id="document_type"
                    class="form-select @error('reception.dte_type') is-invalid @enderror"
                    wire:model.live="reception.dte_type"
                    wire:loading.attr="disabled"
                    wire:target="digitalInvoiceFile"
                    wire:change="toggleFacturaElectronicaFields($event.target.value)"
                    >
                    <option></option>
                    <option value ="guias_despacho">Guía de Despacho</option>
                    <option value ="factura_electronica">Factura Electronica Afecta</option>
                    <option value ="factura_exenta">Factura Electronica Exenta</option>
                    <option value ="boleta_honorarios">Boleta Honorarios</option>
                    <option value ="boleta_electronica">Boleta Electrónica</option>
                </select>
                @error('reception.dte_type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group col-2">
            <label for="folio">Folio*</label>
            <input type="number" class="form-control" id="folio" wire:model.live="folio" autocomplete="off"
                min="1" 
                wire:loading.attr="disabled"
                wire:target="digitalInvoiceFile"
                wire:change="loadDteData()"
                >
            @error('folio')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

    </div>




    <div class="row mb-3 g-2">

        <div class="form-group col-4">
            <label for="razonSocial">Razón Social*</label>
            <input type="text" class="form-control" id="razonSocial" wire:model.live="razonSocial"
                autocomplete="off" wire:loading.attr="disabled"
                    wire:target="digitalInvoiceFile">
            @error('razonSocial')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>





    {{--
        @if($showFacturaElectronicaFields || $showAllFields)
    --}}
        
        <div class="form-group col-2">
            <label for="montoNeto">Monto Neto</label>
            <input type="number" class="form-control" id="montoNeto" wire:model="montoNeto"
                autocomplete="off" min="1000"
                wire:loading.attr="disabled"
                wire:target="digitalInvoiceFile"
                wire:change="calculateTotalAmount"
            >
            @error('montoNeto')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        
        <div class="form-group col-2" >
            <label for="montoIva">Iva</label>
            <input type="number" class="form-control" id="montoIva" wire:model="montoIva"
                autocomplete="off" min="1000"
                wire:loading.attr="disabled"
                wire:target="digitalInvoiceFile"
                wire:change="calculateTotalAmount"
            >
            @error('montoIva')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    {{--    
    @endif
    --}}


    {{--
    @if($showFacturaExentaFields || $showAllFields)
    --}}
        <div class="form-group col-2">
            <label for="montoExento">Monto Exento</label>
            <input type="number" class="form-control" id="montoExento" wire:model="montoExento"
                autocomplete="off" min="1000"
                wire:loading.attr="disabled"
                wire:target="digitalInvoiceFile"
                wire:change="calculateTotalAmount"
            >
            @error('montoExento')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    {{--
    @endif
    --}}

        <div class="form-group col-2">
            <label for="montoTotal">Monto Total</label>
            <input type="number" class="form-control" id="montoTotal" wire:model="montoTotal"
                @if($readonly) readonly @endif
                autocomplete="off" min="1000" 
                wire:loading.attr="disabled"
                wire:target="digitalInvoiceFile"
                >
            @error('montoTotal')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="dte_date">Fecha de documento*</label>
                <input type="date"
                    class="form-control @error('reception.dte_date') is-invalid @enderror"
                    wire:model="reception.dte_date" 
                    wire:loading.attr="disabled"
                    wire:target="digitalInvoiceFile">
            </div>
            @error('reception.dte_date')
                    <span class="text-danger">{{ $message }}</span>
            @enderror
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
                    placeholder="Automático"
                    wire:loading.attr="disabled"
                    wire:target="digitalInvoiceFile"
                    >
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="reception-date">Fecha acta*</label>
                <input type="date"
                    class="form-control @error('reception.date') is-invalid @enderror"
                    wire:model="reception.date" wire:loading.attr="disabled" wire:target="digitalInvoiceFile">
                @error('reception.date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-2">
            <label for="form-reception-type">Tipo de acta*</label>
            <select class="form-select @error('reception.reception_type_id') is-invalid @enderror"
                wire:model="reception.reception_type_id" wire:loading.attr="disabled"
                wire:target="digitalInvoiceFile">
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
                    wire:model="reception.internal_number" wire:loading.attr="disabled">
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
                    wire:model="reception.header_notes"></textarea>

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

    <div class="row mb-3 g-2">
        <div class="col-md-12">
            <div class="form-group">
                <h5>Ítems</h5>
                <div>
                    <button class="btn btn-primary" wire:click="addItem">Agregar Ítem</button>
                </div>
                <div class="mt-2">
                    @foreach ($items as $index => $item)
                        <div class="row mb-2 g-2" wire:key="item_{{ $index }}">
                            <div class="col-md-2">
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="for-order_completed_{{ $index }}"
                                        wire:click="toggleExento({{ $index }})"
                                        @if($item['exento']) checked @endif
                                        >
                                    <label class="form-check-label" for="flexSwitchCheckDefault_{{ $index }}">Marcar el ítem como exento</label>
                                    <div class="form-text">Esta linea se considerara como exenta</div>
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <input type="text" class="form-control" wire:model="items.{{ $index }}.producto" placeholder="ej: bolsa de basura">
                                @error("items.$index.producto")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            

                            <div class="col-md-1">
                                <input type="text" class="form-control" wire:model="items.{{ $index }}.unidad" placeholder="ej: cm">
                                @error("items.$index.unidad")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <input type="number" class="form-control" wire:model="items.{{ $index }}.cantidad" placeholder="Cant" wire:change="calculateTotal({{ $index }})">
                                @error("items.$index.cantidad")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if($item['exento'])
                                <div class="form-group col-2">
                                    <input type="number" class="form-control" wire:model.live="items.{{ $index }}.precioExento"
                                        autocomplete="off" wire:change="calculateTotal({{ $index }})" placeholder="monto exento"
                                    >
                                    @error("items.$index.precioExento")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @else
                                <div class="form-group col-2">
                                    <input type="number" class="form-control" wire:model.live="items.{{ $index }}.precioNeto"
                                        autocomplete="off"
                                        wire:change="calculateTotal({{ $index }})"
                                        placeholder="monto neto"
                                    >
                                    @error("items.$index.precioNeto")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-md-2">
                                <input type="number" class="form-control" wire:model.live="items.{{ $index }}.total" readonly>
                                @error("items.$index.total")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger" wire:click="removeItem({{ $index }})">
                                    <i class="fas fa-trash"></i> Eliminar Item
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>




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




    <div class="row mt-3">
        <div class="col-6 text-primary">
            <button class="btn btn-primary" wire:click="save">
                Crear
            </button>

        </div>
    </div>


<hr>
<br>
<br>
<br>
        <!----------------------------------->
        <!-- Preview del acta de recepción -->
        <!----------------------------------->
        <div class="row mb-3">
            <div class="col-9">
                <div class="bd-example m-0 border-0">
                    <svg class="bd-placeholder-img img-thumbnail" 
                            width="150" height="150" 
                            xmlns="http://www.w3.org/2000/svg" 
                            role="img" 
                            aria-label="logo" 
                            focusable="false">
                        <title>Logo Institución</title>
                        <rect width="100%" height="100%" fill="#CCCCCC"></rect>
                        <text x="33%" y="50%" dy=".3em">
                            Logo
                        </text>
                    </svg>
                </div>
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
                    N/A
                </td>
                <th>
                    Proveedor
                </th>
                <td>
                    {{ $razonSocial ?? '' }}
                </td>
                <th>
                    RUT Proveedor
                </th>
                <td>
                    {{ $emisor ?? '' }}
                </td>
            </tr>
            <tr>
                <th>
                    N° Documento
                </th>
                <td>
                    {{ $folio ?? '' }}
                </td>
                <th>
                    Tipo de documento
                </th>
                <td>
                    {!! $reception['dte_type'] ?? '<span class="text-danger">Falta el tipo de documento</span>' !!}
                </td>
                <th>
                    Fecha Emisión:
                </th>
                <td>
                    {{ $reception['dte_date'] ?? '' }}
                </td>
            </tr>
        </table>

        <table class="table table-sm table-bordered mb-3">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad / Unidad</th>
                    <th>Precio Unitario</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                

            @foreach ($items as $item)
                @if ($item['cantidad'])
                    <tr>
                        <td>{{ $item['producto'] }}</td>
                        <td>{{ $item['cantidad'] }} / {{ $item['unidad'] }}</td>
                        <td style="text-align: right;">
                            @if (!empty($item['precioNeto']))
                                {{ money(floatval($item['precioNeto'])) }}
                            @elseif (!empty($item['precioExento']))
                                {{ money(floatval($item['precioExento'])) }}
                            @endif
                        </td>
                        <td style="text-align: right;">{{ money(floatval($item['total'])) }}</td>
                    </tr>
                @endif
            @endforeach

            
                <tr>
                    <td colspan="3">
                    </td>
                    <td colspan="1">
                        <table>
                            <tr>
                                <th width="100">Neto</th>
                                <td>$</td>
                                <td width="100"
                                    style="text-align: right;">{{ money($montoNeto ?? 0) }}</td>
                            </tr>
                            <tr>
                                <th>Subtotal</th>
                                <td>$</td>
                                <td style="text-align: right;">{{ money($montoNeto ?? 0) }}</td>
                            </tr>
                            @if($montoIva)
                                <tr>
                                    <th>IVA</th>
                                    <td>$</td>
                                    <td style="text-align: right;">{{ money($montoIva ?? 0) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Total</th>
                                <td>$</td>
                                <td style="text-align: right;">
                                    <b>{{ money($montoTotal ?? 0) }}</b>
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
                    Unidad e Institución del firmante<br>
                @endif
            </div>
            <div class="col">
                @if (array_key_exists('center', $approvals))
                    <b>{{ $this->approvals['center']['signerShortName'] }}</b><br>
                    Unidad e Institución del firmante<br>
                @endif
            </div>
            <div class="col">
                @if (array_key_exists('right', $approvals))
                    <b>{{ $approvals['right']['signerShortName'] }}</b><br>
                    Unidad e Institución del firmante<br>
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





    @section('custom_js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/jquery.rut.chileno.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#emisor').rut();
    });
    </script>
    @endsection



</div>