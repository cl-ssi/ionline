<div>
    <div class="form-row">
        <fieldset class="form-group col-md-3">
            <label for="program-id">Programa</label>
            <input
                type="text"
                class="form-control"
                value="{{ $control->program_name }}"
                readonly
            >
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-3">
            <label for="barcode">Código de Barra</label>
            <input
                type="text"
                class="form-control @error('barcode') is-invalid @enderror"
                min="0"
                wire:model="barcode"
                id="barcode"
                readonly
            >
            @error('barcode')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="product-search">Producto o Servicio</label>
            <select
                class="form-control  @error('control_item_id') is-invalid @enderror"
                wire:model="control_item_id"
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
            @error('control_item_id')
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
                wire:model="quantity"
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
        <fieldset class="form-group col-md-12">
            <button class="btn btn-primary" wire:click="addProduct">
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                    wire:loading
                    wire:target="addProduct"
                ></span>
                Agregar producto
            </button>
        </fieldset>
    </div>
</div>
