<div>
    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="search-store-product">Buscar Producto</label>
            <input
                type="text"
                class="form-control"
                id="search-store-product"
                placeholder="Búsqueda por código de barra o nombre"
                wire:model.live.debounce.1500ms="search_store_product"
            >
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-6">
            <label for="product-search">Selecciona un Producto</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" wire:loading.remove wire:target="search_store_product">
                        @if($controlItems->count() == 0)
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
                    class="form-control @error('control_item_id') is-invalid @enderror"
                    wire:model.live.debounce.1500ms="control_item_id"
                    id="product-search"
                >
                    <option value="">Selecciona un producto o servicio</option>
                    @foreach($controlItems as $controlItem)
                        <option value="{{ $controlItem->id }}">
                            {{ $controlItem->product->product->name }} -
                            {{ $controlItem->product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('control_item_id')
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
                value="{{ $barcode }}"
                id="barcode"
                readonly
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
                min="1"
                max="{{ $max }}"
                wire:model.live.debounce.1500ms="quantity"
                id="quantity"
            >
            <small id="quantity" class="form-text text-muted">
                {{ $max }} disponible(s)
            </small>
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
                wire:loading.attr="disabled"
                wire:target="addProduct"
                wire:click="addProduct"
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                    wire:loading
                    wire:target="addProduct"
                >
                </span>

                <span
                    wire:loading.remove
                    wire:target="addProduct"
                >
                    <i class="fas fa-plus"></i>
                </span>

                Agregar producto
            </button>
        </fieldset>
    </div>
</div>
