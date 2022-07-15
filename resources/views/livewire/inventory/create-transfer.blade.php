<div>
    @section('title', 'Generar Traspaso')

    @include('inventory.nav')

    <h4 class="mb-3">
        Generar Traspaso
    </h4>

    <div class="form-row g-2 mb-2">
        <fieldset class="col-md-4">
            <label for="product" class="form-label">
                Producto
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="product"
                value="{{ $inventory->product->product->name }}"
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
                value="{{ $inventory->product->name }}"
                readonly
            >
        </fieldset>
    </div>

    @livewire('inventory.register-movement', ['inventory' => $inventory])

    <h5 class="mt-3">Historial del ítem</h5>

    @livewire('inventory.movement-index', ['inventory' => $inventory])
</div>
