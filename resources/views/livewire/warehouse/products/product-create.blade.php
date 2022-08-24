<div>
    <h5>Crear Producto</h5>

    @include('warehouse.products.partials.form', [
        'product' => null
    ])

    <button
        class="btn btn-primary"
        wire:click="createProduct"
        wire:target="createProduct"
        wire:loading.attr="disabled"
    >
        <span
            class="spinner-border spinner-border-sm"
            role="status"
            wire:loading
            wire:target="createProduct"
            aria-hidden="true"
        >
        </span>

        <span wire:loading.remove wire:target="createProduct">
            <i class="fas fa-save"></i>
        </span>

        Guardar
    </button>
    <a
        href="{{ route('warehouse.products.index', ['store' => $store, 'nav' => $nav]) }}"
        class="btn btn-outline-primary"
    >
        Cancelar
    </a>
</div>
