<div>
    <h5>Editar Categoría</h5>

    @include('warehouse.categories.partials.form', [
        'category' => $category,
        'store' => $store
    ])

    <button wire:click="updateCategory" class="btn btn-primary">Actualizar</button>
    <a
        href="{{ route('warehouse.categories.index', ['store' => $store, 'nav' => $nav]) }}"
        class="btn btn-outline-primary"
    >
        Cancelar
    </a>

</div>
