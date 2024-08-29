<div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label class="font-weigth-bold mr-2">Tipo:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model.live.debounce.1000ms="type" id="option-1" value="1">
                <label class="form-check-label" for="option-1">Producto nuevo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model.live.debounce.1000ms="type" id="option-2" value="0">
                <label class="form-check-label" for="option-2">Producto existente</label>
            </div>
        </div>
    </div>

    @if($type)
        <div class="form-row">
            <fieldset class="form-group col-md-3">
                <label for="product-search">Buscar Producto o Servicio</label>
                <input
                    wire:model.live.debounce.1500ms="search_unspsc_product"
                    id="product-search"
                    class="form-control"
                    type="text"
                >
            </fieldset>

            <fieldset class="form-group col-md-6">
                <label for="product-id">Selecciona un Producto o Servicio</label>
                @livewire('unspsc.product-search')
                <input
                    class="form-control @error('unspsc_product_id') is-invalid @enderror"
                    type="hidden"
                >
                @error('unspsc_product_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="form-group col-md-3">
                <label for="category-id">Categoría</label>
                <select
                    class="form-control @error('category_id') is-invalid @enderror"
                    wire:model.live.debounce.1500ms="category_id"
                    id="wre-category-id"
                >
                    <option value="">Sin categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>
        </div>
    @endif

    @if($type == 0)
        <div class="form-row">
            <fieldset class="form-group col-md-4">
                <label for="search-store-product">Buscar Producto</label>
                <input
                    type="text"
                    class="form-control"
                    min="0"
                    placeholder="Búsqueda por código de barra o nombre"
                    wire:model.live.debounce.1500ms="search_store_product"
                    id="search-store-product"
                >
            </fieldset>
        </div>
    @endif

    <div class="form-row">
        @if($type == 0)
            <fieldset class="form-group col-md-6">
                <label for="wre-product-id">Selecciona un Producto</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" wire:loading.remove wire:target="search_store_product">
                            @if($store_products->count() == 0)
                                <i class="fas fa-times text-danger"></i>
                            @else
                                <i class="fas fa-check text-success"></i>
                            @endif
                        </span>
                        <span class="input-group-text" wire:loading wire:target="search_store_product">
                            <span
                                class="spinner-border spinner-border-sm"
                                role="status"
                                aria-hidden="true"
                            >
                            </span>
                            <span class="sr-only">...</span>
                        </span>
                    </div>
                    <select
                        class="form-control @error('wre_product_id') is-invalid @enderror"
                        wire:model.live.debounce.1500ms="wre_product_id"
                        id="wre-product-id"
                    >
                        <option value="">Selecciona un producto</option>
                        @foreach($store_products as $product)
                            <option value="{{ $product->id }}">
                                {{ optional($product->product)->name }} - {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <small id="product-id" class="form-text text-muted">
                    {{ $store_products->count() }} resultados.
                </small>
                @error('wre_product_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="form-group col-md-3">
                <label for="product-barcode">Código de Barra</label>
                <input
                    type="text"
                    class="form-control @error('product_barcode') is-invalid @enderror"
                    min="0"
                    wire:model.live.debounce.1500ms="product_barcode"
                    id="product-barcode"
                    @if($type == 0) disabled @endif
                >
                @error('product_barcode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>
        @else
            <fieldset class="form-group col-md-6">
                <label for="description">Descripción <small>(especificación técnica)</small></label>
                <input
                    type="text"
                    class="form-control @error('description') is-invalid @enderror"
                    min="0"
                    wire:model.live.debounce.1500ms="description"
                    id="description"
                >
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="form-group col-md-3">
                <label for="barcode">Código de Barra</label>
                <input
                    type="text"
                    class="form-control @error('barcode') is-invalid @enderror"
                    min="0"
                    wire:model.live.debounce.1500ms="barcode"
                    id="barcode"
                    @if($type == 0) disabled @endif
                >
                @error('barcode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>
        @endif

        <fieldset class="form-group col-md-3">
            <label for="quantity">Cantidad</label>
            <input
                type="number"
                class="form-control @error('quantity') is-invalid @enderror"
                min="0"
                wire:model.live.debounce.1500ms="quantity"
                id="quantity"
            >
            @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-12 text-right">
            <button
                class="btn btn-primary"
                wire:click="addProduct"
                wire:loading.attr="disabled"
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                    wire:loading
                    wire:target="addProduct"
                >
                </span>

                <span wire:loading.remove wire:target='addProduct'>
                    <i class="fas fa-plus"></i>
                </span>

                Agregar producto
            </button>
        </fieldset>
    </div>
</div>
