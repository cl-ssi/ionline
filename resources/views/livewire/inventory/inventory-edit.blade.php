<div>
    @section('title', 'Editar Inventario')

    @include('inventory.nav', [
        'establishment' => $establishment
    ])

    <div class="row">
        <div class="col">
            <h3 class="mb-3">
                Detalle del ítem
            </h3>
        </div>
        <div class="col text-right">
            <a
                href="{{ route('inventories.pending-inventory', [
                    'establishment' => $establishment
                ]) }}"
                class="btn btn-primary"
            >
                Atrás
            </a>
        </div>
    </div>

    <div class="form-row mb-3">
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
                Producto <small>(Artículo)</small>
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

    <div class="form-row mb-3">
        <fieldset class="col-md-2">
            <label for="number-inventory" class="form-label">
                Nro. Inventario
            </label>
            <input
                type="text"
                class="form-control @error('number_inventory') is-invalid @enderror"
                id="number-inventory"
                wire:model.debounce.1500ms="number_inventory"
            >
            @error('number_inventory')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-1">
            <label for="useful-life" class="form-label">
                Vida útil
            </label>
            <input
                type="text"
                class="form-control @error('useful_life') is-invalid @enderror"
                id="useful-life"
                wire:model.debounce.1500ms="useful_life"
            >
            @error('useful_life')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-3">
            <label for="status" class="form-label">
                Estado
            </label>
            <select
                class="form-control @error('status') is-invalid @enderror"
                id="status"
                wire:model.debounce.1500ms="status"
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

        <fieldset class="col-md-3">
            <label for="depreciation" class="form-label">
                Depreciación
            </label>
            <input
                type="text"
                class="form-control @error('depreciation') is-invalid @enderror"
                id="depreciation"
                wire:model.debounce.1500ms="depreciation"
            >
            @error('depreciation')
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
                wire:model.debounce.1500ms="serial_number"
            >
            @error('serial_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row mb-3">
        <fieldset class="col-md-3">
            <label for="brand" class="form-label">
                Marca
            </label>
            <input
                type="text"
                class="form-control @error('brand') is-invalid @enderror"
                id="brand"
                wire:model.debounce.1500ms="brand"
            >
            @error('brand')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-3">
            <label for="model" class="form-label">
                Modelo
            </label>
            <input
                type="text"
                class="form-control @error('model') is-invalid @enderror"
                id="model"
                wire:model.debounce.1500ms="model"
            >
            @error('model')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>


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
                    Fecha Compra OC
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
                    Valor OC
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

        <fieldset class="col-md-1">
            <label for="subtitle" class="form-label">
                Subtítulo
            </label>
            <input
                type="text"
                class="form-control"
                id="subtitle"
                value="{{ $inventory->subtitle }}"
                disabled
                readonly
            >
        </fieldset>

        <fieldset class="col-md-2">
            <label for="cost-center" class="form-label">
                Centro Costo
            </label>
            <input
                type="text"
                class="form-control"
                id="cost-center"
                value="???"
                disabled
                readonly
            >
        </fieldset>

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

        <fieldset class="col-md-3">
            <label for="financing" class="form-label">
                Financiamiento
            </label>
            <input
                type="text"
                class="form-control"
                id="financing"
                value="Donación o Compra"
                disabled
            >
        </fieldset>

        @if($inventory->control)
            <fieldset class="col-md-4">
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
                        value="{{ $inventory->control->origin->name }}"
                    @endif
                    disabled
                >
            </fieldset>
        @endif

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
    </div>

    <div class="form-row mb-3">
        <fieldset class="col-md-12">
            <label for="observations" class="form-label">
                Observaciones
            </label>
            <textarea
                id="observations"
                cols="30"
                rows="4"
                class="form-control @error('observations') is-invalid @enderror"
                wire:model.debounce.1500ms="observations"
            >
            </textarea>
            @error('observations')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row mb-3">
        <div class="col text-right">
            <button class="btn btn-primary" wire:click="update">
                <i class="fas fa-save"></i> Actualizar
            </button>
        </div>
    </div>

    <h5 class="mt-3">Registrar nuevo traslado y solicitud de recepción</h5>

    @livewire('inventory.register-movement', ['inventory' => $inventory ])

    @livewire('inventory.update-movement', ['inventory' => $inventory])

    <h5 class="mt-3">Registrar baja del ítem</h5>

    @livewire('inventory.add-discharge-date', ['inventory' => $inventory])

    <div class="row">
        <div class="col">
            <h5 class="mt-3">Historial del ítem</h5>
            @livewire('inventory.movement-index', ['inventory' => $inventory])
        </div>
        @if($inventory->control)
            <div class="col">
                <h5 class="mt-3">Facturas</h5>
                @livewire('warehouse.invoices.list-invoices', ['control' => $inventory->control])
            </div>
        @endif
    </div>

</div>
