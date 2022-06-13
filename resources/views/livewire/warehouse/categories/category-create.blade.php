<div>
    <h5>Crear Categoría</h5>

    @include('warehouse.categories.partials.form', [
        'category' => null
    ])

    <button wire:click="createCategory" class="btn btn-primary">Guardar</button>
    <a href="{{ route('warehouse.categories.index', $store) }}" class="btn btn-outline-primary">Cancelar</a>
</div>
