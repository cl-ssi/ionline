<div>    
    <!-- Campo de búsqueda -->
    <div class="row g-2 d-print-none mb-3">
        <fieldset class="form-group col-md-4">
            <label for="oc">Orden de Compra</label>
            <input 
                wire:model.live="filter_purchase_order" 
                id="filter_purchase_order" 
                class="form-control" 
                placeholder="Ingrese la orden de compra" 
                autocomplete="off"
            >
        </fieldset>
    </div>

    <!-- Icono de carga -->
    <div wire:loading wire:target="filter_purchase_order" class="mb-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Tabla de resultados -->
    @if(!empty($receptions))
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>OC</th>
                        <th>Proveedor</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Responsable</th>
                        <th>Fecha Recepción</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($receptions as $reception)
                        <tr class="{{ $selectedReception && $selectedReception->id == $reception->id ? 'table-primary' : '' }}">
                            <td class="text-center">{{ $reception->id }}</td>
                            <td>{{ $reception->purchase_order }}</td>
                            <td>{{ $reception->purchaseOrder?->json->Listado[0]->Proveedor->Nombre ?? 'N/A' }}</td>
                            <td class="text-center">{{ $reception->items->count() }}</td>
                            <td class="text-end">$ {{ number_format($reception->total, 0, ',', '.') }}</td>
                            <td>{{ $reception->responsable?->shortName ?? 'N/A' }}</td>
                            <td class="text-center">{{ $reception->date->format('Y-m-d') }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" wire:click="selectReception({{ $reception->id }})" wire:loading.attr="disabled">
                                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="selectReception({{ $reception->id }})"></i>
                                    <span wire:loading.remove wire:target="selectReception({{ $reception->id }})">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center mt-4">No hay actas de recepción disponibles.</p>
    @endif

    <!-- Icono de carga mientras se obtienen los ítems -->
    <div wire:loading wire:target="selectReception" class="mb-3 d-flex justify-content-center align-items-center">
        <div class="text-center">
            <h3 class="spinner-border"
                role="status"
                wire:loading>
            </h3>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <!-- Tabla de ítems de la recepción seleccionada -->
    @if($selectedReception)
        <hr>

        <!-- Información adicional de la recepción -->
        <div class="row mb-3">
            <div class="col">
                <div class="p-3 rounded shadow-sm" style="background-color: #f8f9fa; border: 1px solid #ddd;">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="oc" class="form-label">Orden de Compra:</label>
                                <p id="oc" class="mb-0"><b>{{ $purchase_order }}</b></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="invoice_date" class="form-label">Fecha Emisión Factura:</label>
                                <p id="invoice_date" class="mb-0"><b>{{ isset($dte_date) ? $dte_date->format('Y-m-d') : 'N/A' }}</b></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="net_amount" class="form-label">Monto Total Neto:</label>
                                <p id="net_amount" class="mb-0">$ <b>{{ number_format($neto, 0, ',', '.') }}</b></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                
                                <label for="due_date" class="form-label">F.Vencimiento Factura:</label>
                                <p id="due_date" class="mb-0"><b>{{ isset($dte_due_date) ? $dte_due_date->format('Y-m-d') : 'N/A' }}</b></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="despatch_guide" class="form-label">Guía de Despacho:</label>
                                <p id="despatch_guide" class="mb-0"><b>{{ $despatch_guide ?? 'N/A' }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mt-4">Ítems de la Recepción #{{ $selectedReception->id }}</h4>

        @if(!$loadingItems)
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>ID Ítem</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                            <th></th> <!-- Nueva columna para el botón -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedReception->items as $item)
                        @if(!collect($addedProducts)->contains('selectedItem', $item->id))
                            <tr class="{{ $selectedItem == $item->id ? 'table-warning' : '' }}"> <!-- Clase para resaltar fila seleccionada -->
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->Producto }}</td>
                                <td>{{ $item->Cantidad }}</td>
                                <td class="text-end">$ {{ number_format($item->PrecioNeto, 0, ',', '.') }}</td>
                                <td class="text-end">$ {{ number_format($item->Total, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" wire:click="selectItem({{ $item->id }})" wire:loading.attr="disabled" wire:target="selectItem({{ $item->id }})">
                                        <!-- Mostrar spinner durante la carga -->
                                        <i class="fa fa-spinner fa-spin" wire:loading wire:target="selectItem({{ $item->id }})"></i>
                                        <!-- Mostrar ícono de selección cuando no está cargando -->
                                        <span wire:loading.remove wire:target="selectItem({{ $item->id }})">
                                            <i class="bi bi-check-circle"></i>
                                        </span>
                                    </button>
                                </td> <!-- Botón para seleccionar el ítem -->
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
                
            @if($selectedItem)
                <div class="row">
                    <div class="col-3">
                        <div class="mb-3">
                            <label for="for_barcode" class="form-label">Código producto</label>
                            <input type="text" class="form-control" id="for_barcode" placeholder="" name="barcode" wire:model.live="barcode" required>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="mb-3">
                            <label for="for_experto_id" class="form-label">Código experto</label>
                            <input type="text" class="form-control" id="for_experto_id" placeholder="" name="experto_id" wire:model.live="experto_id">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-3">
                            <label for="for_product" class="form-label">Producto</label> <!-- 'form-label' en BT5, se mantiene en BT4 -->
                            <div>
                                <select id="for_product" class="form-select" name="product_id" wire:model="product_id" wire:change="change" required> <!-- 'form-control' funciona en ambas versiones -->
                                    <option></option>
                                    @foreach ($products as $key => $product_item)
                                        <option value="{{$product_item->id}}">{{$product_item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($experto_id)
                                <button type="button" wire:click="toggleSecondDiv" class="btn btn-sm btn-primary mt-2">Editar nombre del producto</button> <!-- Compatible con ambas versiones -->
                            @endif
                        </div>
                    </div>


                    <div class="col-2">
                        <div class="mb-3">
                            <label for="for_filtro_producto" class="form-label"><i>Filtro producto</i></label>
                            <input type="text" class="form-control" id="for_filtro_producto" placeholder="" wire:model.live="filtro_producto">
                        </div>
                    </div>

                    <input type="hidden" id="for_unity" name="unity" wire:model="unity"/>
                </div>

                <div class="row" style="{{ $showSecondDiv ? '' : 'display: none' }};">
                    <div class="col-2"></div>
                    <div class="col-2"></div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="for_product_name" class="form-label">Modificar nombre producto</label>
                            <input type="text" class="form-control" id="for_product_name" name="name" wire:model.live="product_name">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-3">
                        <div class="mb-3">
                            <label for="for_unit_cost" class="form-label">Precio</label>
                            <input 
                                step="any" 
                                type="number" 
                                class="form-control" 
                                id="for_unit_cost" 
                                placeholder="Precio" 
                                name="unit_cost" 
                                wire:model="unit_cost" 
                                readonly
                                required
                            >
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="mb-3">
                            <label for="for_quantity" class="form-label">Cantidad</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="for_quantity" 
                                placeholder="" 
                                name="amount" 
                                wire:model="amount" 
                                readonly
                                required
                            >
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="mb-3">
                            <label for="disable_due_date_batch" class="form-label"><br></label>
                            <button 
                                type="button" 
                                wire:click="toggleDueDateBatch" 
                                class="btn btn-primary form-control" 
                                title="Utilizar cuando el producto no tenga fecha de vencimiento o lote."
                            >
                                <i class="fa {{ $due_date_readonly ? 'fa-lock' : 'fa-unlock-alt' }}"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="mb-3">
                            <label for="for_date" class="form-label">F. Vencimiento</label>
                            <input 
                                type="date" 
                                class="form-control {{ $due_date_readonly ? 'bg-light' : '' }}" 
                                id="for_date" 
                                name="due_date" 
                                wire:model="due_date" 
                                {{ $due_date_readonly ? 'readonly' : '' }} 
                                required 
                                max="3000-01-01"
                            >
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="mb-3">
                            <label for="for_lote" class="form-label">Serie/Lote</label>
                            <input 
                                type="text" 
                                class="form-control {{ $batch_readonly ? 'bg-light' : '' }}" 
                                id="for_lote" 
                                placeholder="Número de Lote" 
                                name="batch" 
                                wire:model="batch" 
                                {{ $batch_readonly ? 'readonly' : '' }} 
                                required
                            >
                        </div>
                    </div>
                </div>


                <!-- Botón para agregar producto -->
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary" wire:click="addProduct">
                        <i class="bi bi-plus-circle"></i> Agregar Producto
                    </button>
                </div>

            @endif

            @if(count($addedProducts) > 0)

                <hr>

                <h3>Información a importar</h3>

                <!-- Mensajes de validación específicos para la importación en farmacia -->
                @if (session()->has('import_validation_error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('import_validation_error') }}
                    </div>
                @endif

                <!-- Tabla dinámica para productos agregados -->
                <div class="table-responsive mt-4">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Código producto</th>
                                <th>Código experto</th>
                                <th>Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>F. Vencimiento</th>
                                <th>Serie/Lote</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addedProducts as $product)
                                <tr class="table-success">
                                    <td>{{ $product['barcode'] }}</td>
                                    <td>{{ $product['experto_id'] }}</td>
                                    <td>{{ $product['name'] }}</td>
                                    <td class="text-end">$ {{ number_format($product['unit_cost'], 0, ',', '.') }}</td>
                                    <td>{{ $product['amount'] }}</td>
                                    <td>{{ $product['due_date'] }}</td>
                                    <td>{{ $product['batch'] }}</td>
                                    <td>
                                        <!-- Botón para eliminar producto -->
                                        <button class="btn btn-sm btn-danger" wire:click="removeProduct({{ $loop->index }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <!-- Select de proveedores -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="for_supplier" class="form-label">Proveedores</label>
                            <select class="form-select" wire:model="selectedSupplier">
                                <option value="">Seleccione un proveedor</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Input de filtro de proveedores -->
                    <div class="col-3">
                        <div class="mb-3">
                            <label for="for_supplier_filter" class="form-label">Filtro proveedor</label>
                            <input type="text" class="form-control" id="for_supplier_filter" wire:model.live="supplier_filter" placeholder="Ingrese nombre del proveedor">
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="mb-3">
                            <label for="for_despatch_guide" class="form-label">Guía despacho</label>
                            <input type="text" class="form-control" id="for_despatch_guide" wire:model.live="despatch_guide" placeholder="Ingrese Nro Guía despacho">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="mb-3">
                            <label for="for_order_number" class="form-label">N° pedido (*)</label>
                            <input type="text" class="form-control" id="for_order_number" placeholder="" name="order_number" wire:model="order_number" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="for_note" class="form-label">Nota</label>
                            <input type="text" class="form-control" id="for_note" placeholder="" name="notes" wire:model="notes">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="for_destination" class="form-label">Destino</label>
                            <input type="text" class="form-control" id="for_destination" placeholder="" name="destination" wire:model="destination">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="for_funds" class="form-label">Fondos</label>
                            <input type="text" class="form-control" id="for_funds" placeholder="" name="from" wire:model="from">
                        </div>
                    </div>
                </div>


                <button class="btn btn-success" wire:click="createPharmacyImport">
                    <i class="bi bi-upload"></i> Crear importación en farmacia
                </button>

            @endif

        @endif
    @endif

</div>
