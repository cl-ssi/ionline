<div>
    @section('title', 'Editar Inventario')

    @include('inventory.nav', [
        'establishment' => $establishment
    ])

    @include('layouts.bt5.partials.flash_message')

    <div class="row">
        <div class="col">
            <h3 class="mb-3">
                Detalle del ítem
            </h3>
        </div>

        <div class="col-4">
            @can('Inventory: manager')
                <div class="input-group mb-3">
                    <input
                        type="text"
                        class="form-control form-control-sm @error('observation_delete') is-invalid @enderror"
                        placeholder="Observación de eliminación"
                        wire:model.live.debounce.1500ms="observation_delete"
                    >
                    <button
                        class="btn btn-sm btn-danger"
                        type="button"
                        id="button-addon2"
                        wire:click="deleteItemInventory"
                    >
                        Eliminar Item
                    </button>
                    @error('observation_delete')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif
        </div>

        <div class="col-3 text-end">
            @can('Inventory: manager')
                @if(isset($inventory->number))
                    <button
                        class="btn btn-sm btn-danger"
                        wire:click="unInventory"
                    >
                        <i class="fas fa-trash"></i> Desinventariar
                    </button>
                @endif
            @endcan
            <div>
                @livewire('inventory.toggle-print', ['inventory' => $inventory], key('print-'.$inventory->id))
            </div>

            <a
                href="{{ route('inventories.pending-inventory', [
                    'establishment' => $establishment
                ]) }}"
                class="btn btn-sm btn-primary"
            >
                Atrás
            </a>
        </div>
    </div>

    <div class="row g-2 mb-3">
        <fieldset class="col-md-2">
            <label for="code" class="form-label">
                Código
            </label>
            <input
                type="text"
                class="form-control"
                id="code"
                value="{{ $inventory->unspscProduct->code }}"
                disabled
                readonly
            >
        </fieldset>

        <fieldset class="col-md-3">
            <label for="product" class="form-label">
                Producto <small>(Artículo desc. cod. ONU)</small>
            </label>
            <input
                type="text"
                class="form-control"
                id="product"
                value="{{ $inventory->unspscProduct->name }}"
                disabled
                readonly
            >
        </fieldset>

        <fieldset class="col-md-7">
            <label for="description" class="form-label">
                Descripción <small>(especificación técnica)</small>
            </label>
            <input
                type="text"
                class="form-control"
                id="description"
                value="{{ $inventory->product ? $inventory->product->name : $inventory->description }}"
                disabled
                readonly
            >
        </fieldset>
    </div>

    <div class="row g-2 mb-3">
        <fieldset class="col-md-2">
            <label for="old_number" class="form-label">
                Nro. Inventario Antiguo
            </label>
            <input
                type="text"
                class="form-control"
                id="old_number"
                wire:model="old_number"                
            >
        </fieldset>

        <fieldset class="col-md-10">
            <label for="internal_description" class="form-label">
                Descripción Interna
            </label>
            <input
                type="text"
                class="form-control @error('internal_description') is-invalid @enderror"
                id="internal_description"
                wire:model="internal_description"
                autocomplete="off"
            >
        </fieldset>

    </div>

    <div class="row g-2 mb-3">
        <fieldset class="col-md-4">
            <label for="number-inventory" class="form-label">
                Nro. Inventario
            </label>
            <div class="input-group">
                <input
                    type="text"
                    class="form-control @error('number_inventory') is-invalid @enderror"
                    id="number-inventory"
                    wire:model.live="number_inventory"
                    autocomplete="off"
                >
                <button
                    class="btn btn-primary"
                    wire:click="generateCode"
                    wire:target="generateCode"
                    wire:loading.attr="disabled"
                >
                    <span
                        wire:loading.remove
                        wire:target="generateCode"
                    >
                        <i class="fas fa-qrcode"></i>
                    </span>

                    <span
                        class="spinner-border spinner-border-sm"
                        role="status"
                        wire:loading
                        wire:target="generateCode"
                        aria-hidden="true"
                    >
                    </span>

                    Generar
                </button>

                @can('Inventory: manager')
                    <button
                        class="btn btn-sm btn-info"
                        wire:click="searchFusion"
                    >
                        <i class="fas fa-compress-alt"></i>
                        Fusionar
                    </button>
                @endcan 

                @error('number_inventory')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </fieldset>

        <fieldset class="col-md-3">
            <label for="brand" class="form-label">
                Marca
            </label>
            <input
                type="text"
                class="form-control @error('brand') is-invalid @enderror"
                id="brand"
                wire:model="brand"
                wire:target="searchFusion"
                wire:loading.attr="disabled"
                autocomplete="off"
            >
            @error('brand')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-2">
            <label for="model" class="form-label">
                Modelo
            </label>
            <input
                type="text"
                class="form-control @error('model') is-invalid @enderror"
                id="model"
                wire:model="model"
                autocomplete="off"
            >
            @error('model')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-3">
            <label for="serial-number" class="form-label">
                Número de Serie
            </label>
            <input
                type="text"
                class="form-control @error('serial_number') is-invalid @enderror"
                id="serial-number"
                wire:model="serial_number"
                autocomplete="off"
            >
            @error('serial_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>


    </div>

    <div class="row g-2 mb-3">

        <fieldset class="col-md-3">
            <label for="cost-center" class="form-label">
                Cuenta contable
            </label>
            <select
                type="text"
                class="form-select @error('accounting_code_id') is-invalid @enderror"
                id="cost-center"
                wire:model.live="accounting_code_id"
            >
                <option value="">Seleccione cuenta contable</option>
                @foreach($accountingCodes as $accountingCode)
                    <option value="{{ $accountingCode->id }}">
                    {{ $accountingCode->id }} - {{ $accountingCode->description }}
                    </option>
                @endforeach
            </select>
            @error('accounting_code_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-2">
            <label for="status" class="form-label">
                Estado
            </label>
            <select
                class="form-select @error('status') is-invalid @enderror"
                id="status"
                wire:model.live="status"
            >
                <option value="">Seleccione un estado</option>
                <option value="1">Bueno</option>
                <option value="0">Regular</option>
                <option value="-1">Malo</option>
            </select>
            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </fieldset>


        <fieldset class="col-md-2">
            <label for="useful-life" class="form-label">
                Vida útil
            </label>
            <input
                type="text"
                class="form-control @error('useful_life') is-invalid @enderror"
                id="useful-life"
                wire:model="useful_life"
                autocomplete="off"
            >
            @error('useful_life')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-2">
            <label for="depreciation" class="form-label">
                Depreciación
            </label>
            <input
                type="text"
                class="form-control @error('depreciation') is-invalid @enderror"
                id="depreciation"
                wire:model="depreciation"
                autocomplete="off"
            >
            @error('depreciation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-2">
            <label for="classification" class="form-label">
                Clasificación
            </label>
              <select
                class="form-select @error('classification_id') is-invalid @enderror"
                id="classification"
                wire:model.live="classification_id"
                >
                    <option value="">Seleccione una clasificación</option>
                @foreach($classifications as $classification)
                    <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                @endforeach
            </select>
            @error('classification')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </fieldset>
    </div>

    <div class="row g-2 mb-3">
        @if($inventory->control && $inventory->control->requestForm)
            <fieldset class="col-md-3">
                <label for="date-reception" class="form-label">
                    Formulario Requerimiento
                </label>
                <br>
                <a
                    class="btn btn-primary btn-block"
                    href="{{ route('request_forms.show', $inventory->control->requestForm) }}"
                    target="_blank"
                >
                    <i class="fas fa-file-alt"></i> #{{ $inventory->control->requestForm->id }}
                </a>
            </fieldset>
        @endif

        @if($inventory->po_id)
            <fieldset class="col-md-2">
                <label for="oc" class="form-label">
                    OC
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="oc"
                    value="{{ $inventory->po_code }}"
                    disabled
                    readonly
                >
            </fieldset>

            <fieldset class="col-md-2">
                <label for="date-oc" class="form-label">
                    Fecha OC
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="date-oc"
                    value="{{ $inventory->po_date }}"
                    disabled
                    readonly
                >
            </fieldset>

            <fieldset class="col-md-2">
                <label for="value-oc" class="form-label">
                    Valor
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="value-oc"
                    value="${{ money($inventory->po_price) }}"
                    disabled
                    readonly
                >
            </fieldset>
        @endif

        @if($inventory->control && $inventory->control->requestForm && $inventory->control->requestForm->associateProgram)
            <fieldset class="col-md-3">
                <label for="financing" class="form-label">
                    Programa
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="financing"
                    value="{{ $inventory->control->requestForm->associateProgram->name }}"
                    disabled
                >
            </fieldset>
        @endif

    </div>


    <div class="row g-2 mb-3">

        @if($inventory->control)
            <fieldset class="col-md-5">
                <label for="supplier" class="form-label">
                    @if($inventory->control->isPurchaseOrder())
                        Proveedor
                    @else
                        Origen
                    @endif
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="supplier"
                    @if($inventory->control->isPurchaseOrder())
                        value="{{ $inventory->purchaseOrder->supplier_name }}"
                    @else
                        value="{{ $inventory->control->origin?->name }}"
                    @endif
                    disabled
                >
            </fieldset>
        @endif

        <fieldset class="col-md-2">
            <label for="dte-number" class="form-label">
                Número Factura
            </label>
            <input
                type="text"
                class="form-control"
                id="dte-number"
                value="{{ $inventory->dte_number }}"

            >
        </fieldset>


        <fieldset class="col-md-3">
            <label for="po_code" class="form-label">
                OC
            </label>
            <input
                type="text"
                class="form-control"
                id="po_code"
                wire:model="po_code"
            >
        </fieldset>

        @if($inventory->control && $inventory->control->invoice_url)
            <fieldset class="col-md-2">
                <label for="date-reception" class="form-label">
                    Factura
                </label>
                <br>
                <a
                    class="btn btn-primary btn-block"
                    href="{{ asset($inventory->control->invoice_url) }}"
                    target="_blank"
                >
                    <i class="fas fa-eye"></i> Ver archivo
                </a>
            </fieldset>
        @endif

        @if($inventory->control)
            <fieldset class="col-md-2">
                <label for="date-reception" class="form-label">
                    Ingreso bodega
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="date-reception"
                    value="{{ $inventory->control->date->format('Y-m-d') }}"
                    disabled
                    readonly
                >
            </fieldset>
        @endif
    </div>

    @if($inventory->po_code)
        <div >
            <h5 class="mt-3">Facturas relacionadas con la OC</h5>
            @livewire('warehouse.invoices.list-invoices', ['inventory' => $inventory])
        </div>
    @endif

    <div class="row g-2 mb-3">
        <fieldset class="col-md-12">
            <label for="observations" class="form-label">
                Observaciones
            </label>
            <textarea
                id="observations"
                cols="30"
                rows="4"
                class="form-control @error('observations') is-invalid @enderror"
                wire:model.live.debounce.1500ms="observations"
            >
            </textarea>
            @error('observations')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="row g-2 mb-3">
        <div class="col text-end">
            <button
                class="btn btn-primary"
                wire:click="inventoryUpdate"
                wire:target="inventoryUpdate"
                wire:loading.attr="disabled"
            >
                <span
                    wire:loading.remove
                    wire:target="inventoryUpdate"
                >
                    <i class="fas fa-save"></i>
                </span>

                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="inventoryUpdate"
                    aria-hidden="true"
                >
                </span>

                Actualizar
            </button>
        </div>
    </div>

    <h5 class="mt-3">Registrar nuevo traslado y solicitud de recepción</h5>

    @livewire('inventory.register-movement', ['inventory' => $inventory ])

    @livewire('inventory.update-movement', ['inventory' => $inventory], key('update-movement-'.$inventory->id))

    <h5 class="mt-3">Registrar baja del ítem</h5>

    @livewire('inventory.add-discharge-date', ['inventory' => $inventory], key('discharge-'.$inventory->id))

    <div class="row">
        <div class="col">
            <h5 class="mt-3">Historial del ítem</h5>
            @livewire('inventory.movement-index', [
                'inventory' => $inventory,
                'data_preview' => $data_preview,
            ], key('movement-'.$inventory->id))
        </div>
    </div>

    <hr>

    @canAny(['be god','Inventory: manager'])
        @include('partials.audit', ['audits' => $inventory->audits()] )
    @endcan

    

    <!-- Nila comenta ruido visual
        <h3>Productos del mismo tipo</h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Nº Inventario</th>
                <th>Responsable</th>
                <th>Ubicación</th>
                <th>Descripción</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($sameProductItems as $sameProductItem)
            <tr>
                <td>{{  $sameProductItem->number ?? 'Sin número' }}</td>
                <td>{{  $sameProductItem->responsible?->shortName ?? 'No asignado' }}</td>
                <td>{{  $sameProductItem->place?->name ?? 'No asignado' }}</td>
                <td>
                {{ $inventory->product ? $inventory->product->name : $inventory->description }}
                </td>
                <td>
                    <a
                        class="btn btn-sm btn-primary @cannot('Inventory: edit') disabled @endcannot"
                        href="{{ route('inventories.edit', [
                            'inventory' => $sameProductItem,
                            'establishment' => $establishment,
                        ]) }}"
                    >
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> 
    -->
</div>
