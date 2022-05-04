<div>
    <h5>Editar Producto</h5>

    @include('warehouse.products.partials.form', [
        'store' => $store,
        'product' => $product
    ])

    <button wire:click="updateProduct" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('warehouse.categories.index', $store)}}" class="btn btn-outline-primary">Cancelar</a>
</div>
