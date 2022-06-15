<div class="form-row mt-3">
    <fieldset class="form-group col-md-4">
        <label for="store-id">Bodega</label>
        <input
            type="text"
            id="store-id"
            class="form-control"
            value="{{ optional($store)->name }}"
            disabled
        >
    </fieldset>

    <fieldset class="form-group col-md-3">
        <label for="name">Nombre</label>
        <input type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            wire:model.debounce.1500ms="name"
            placeholder="Ingresa el nombre"
            value="{{ old('name', optional($product)->name) }}"
            required
        >
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-3">
        <label for="barcode">Código Barra</label>
        <input type="text"
            class="form-control @error('barcode') is-invalid @enderror"
            id="barcode"
            wire:model.debounce.1500ms="barcode"
            placeholder="Ingresa el código de barra"
            value="{{ old('barcode', optional($product)->barcode) }}"
        >
        @error('barcode')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="category-id">Categoría</label>
        <select
            id="category-id"
            class="form-control @error('category_id') is-invalid @enderror"
            wire:model.debounce.1500ms="category_id"
            required
        >
            <option value="">Selecciona la categoría</option>
            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    {{ optional($product)->category_id == $category->id ? 'selected' : '' }}
                >
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

<div class="form-row">
    <fieldset class="form-group col-md-3">
        <label for="product-search">Buscar Producto o Servicio</label>
        <input
            wire:model.debounce.1500ms="search_unspsc_product"
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
</div>
