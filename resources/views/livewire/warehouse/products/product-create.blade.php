<div>
    <h5>Crear Producto</h5>

    @include('warehouse.products.partials.form', [
        'product' => null
    ])

    <button wire:click="createProduct" class="btn btn-primary">Guardar</button>
    <a href="{{ route('warehouse.products.index', $store) }}" class="btn btn-outline-primary">Cancelar</a>
</div>
