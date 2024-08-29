<div>
    <h5>Editar Producto</h5>

    @include('warehouse.products.partials.form', [
        'store' => $store,
        'product' => $product
    ])

    <button
        class="btn btn-primary"
        wire:click="updateProduct"
        wire:target="updateProduct"
        wire:loading.attr="disabled"
        >
        <span
            class="spinner-border spinner-border-sm"
            role="status"
            wire:loading
            wire:target="updateProduct"
            aria-hidden="true"
        >
        </span>

        <span wire:loading.remove wire:target="updateProduct">
            <i class="fas fa-save"></i>
        </span>

        Actualizar
    </button>

    <a
        href="{{ route('warehouse.products.index', ['store' => $store, 'nav' => $nav])}}"
        class="btn btn-outline-primary"
    >
        Cancelar
    </a>
</div>

@section('custom_js')
<script>
    document.addEventListener('livewire:init', function () {
        var searchUnspscProduct = @this.search_unspsc_product;
        var unspscId = @this.unspsc_product_id;

        Livewire.emit('searchProduct', searchUnspscProduct)
        Livewire.emit('productId', unspscId);
    });
</script>
@endsection
