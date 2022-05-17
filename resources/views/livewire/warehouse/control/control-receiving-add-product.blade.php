<div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label class="font-weigth-bold mr-2">Tipo:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="type" id="option-1" value="1">
                <label class="form-check-label" for="option-1">Producto nuevo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="type" id="option-2" value="0">
                <label class="form-check-label" for="option-2">Producto existente</label>
            </div>
        </div>
    </div>

    @if($type)
        <div class="form-row">
            <fieldset class="form-group col-md-3">
                <label for="product-search">Buscar Producto o Servicio</label>
                <input
                    wire:model.debounce.600ms="search_product"
                    id="product-search"
                    class="form-control"
                    type="text"
                >
            </fieldset>

            <fieldset class="form-group col-md-6">
                <label for="product-id">Selecciona Producto o Servicio</label>
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
                    wire:model="category_id"
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

    <div class="form-row">
        @if($type == 0)
            <fieldset class="form-group col-md-6">
                <label for="wre-product-id">Producto</label>
                <select
                    class="form-control @error('wre_product_id') is-invalid @enderror"
                    wire:model="wre_product_id"
                    id="wre-product-id"
                >
                    <option value="">Selecciona un producto</option>
                    @foreach($store->products as $product)
                        <option value="{{ $product->id }}">
                            {{ optional($product->product)->name }} - {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('wre_product_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>
        @else
            <fieldset class="form-group col-md-6">
                <label for="description">Descripción</label>
                <input
                    type="text"
                    class="form-control @error('description') is-invalid @enderror"
                    min="0"
                    wire:model="description"
                    id="description"
                >
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>
        @endif

        <fieldset class="form-group col-md-3">
            <label for="barcode">Código de Barra</label>
            <input
                type="text"
                class="form-control @error('barcode') is-invalid @enderror"
                min="0"
                wire:model="barcode"
                id="barcode"
                @if($type == 0) disabled @endif
            >
            @error('barcode')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="quantity">Cantidad</label>
            <input
                type="number"
                class="form-control @error('quantity') is-invalid @enderror"
                min="0"
                wire:model="quantity"
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
            <button class="btn btn-primary" wire:click="addProduct" wire:loading.attr="disabled">
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                    wire:loading
                    wire:target="addProduct"
                ></span>
                <i class="fas fa-plus"></i> Agregar producto
            </button>
        </fieldset>
    </div>
</div>
