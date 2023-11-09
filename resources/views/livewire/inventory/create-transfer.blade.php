<div>
    @section('title', 'Generar Traspaso')

    @include('inventory.nav-user')

    <h4 class="mb-3">
        Generar Traspaso
    </h4>

    <div class="form-row g-2 mb-2">
        <fieldset class="col-md-4">
            <label for="number" class="form-label">
                Nro. Inventario
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="number"
                value="{{ $inventory->number }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-4">
            <label for="product" class="form-label">
                Producto
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="product"
                value="{{ optional($inventory->unspscProduct)->name }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-4">
            <label for="description" class="form-label">
                Descripción <small>(especificación técnica)</small>
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="description"
                value="{{-- $inventory->product->name --}}"
                readonly
            >
        </fieldset>
    </div>

    @livewire('inventory.register-movement', ['inventory' => $inventory])

    @livewire('inventory.update-movement', ['inventory' => $inventory])

    <h5 class="mt-3">Historial del ítem</h5>

    @livewire('inventory.movement-index', ['inventory' => $inventory])
</div>
