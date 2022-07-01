<div>
    <h5>Editar Producto</h5>

    @include('warehouse.products.partials.form', [
        'store' => $store,
        'product' => $product
    ])

    <button wire:click="updateProduct" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('warehouse.categories.index', $store)}}" class="btn btn-outline-primary">Cancelar</a>
</div>

@section('custom_js')
<script>
    document.addEventListener('livewire:load', function () {
        var searchUnspscProduct = @this.search_unspsc_product;
        var unspscId = @this.unspsc_product_id;

        Livewire.emit('searchProduct', searchUnspscProduct)
        Livewire.emit('productId', unspscId);
    });
</script>
@endsection
