<div>
    @section('title', 'Completar el traspaso')

    @include('inventory.nav-user')

    <h4 class="mb-3">
        Completar el traspaso
    </h4>

    <div class="row g-2 g-2 mb-2">
        <fieldset class="col-md-4">
            <label for="product" class="form-label">
                Producto
            </label>
            <input
                type="text"
                class="form-control"
                id="product"
                value="{{ $movement->inventory->unspscProduct->name }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-4">
            <label for="description" class="form-label">
                Descripción <small>(especificación técnica)</small>
            </label>
            <input
                type="text"
                class="form-control"
                id="description"
                value="{{ $movement->inventory->product ? $movement->inventory->product->name : $movement->inventory->description }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-4">
            <label for="number-inventory" class="form-label">
                Nro. Inventario
            </label>
            <input
                type="text"
                class="form-control"
                id="number-inventory"
                value="{{ $movement->inventory->number }}"
                readonly
            >
        </fieldset>
    </div>


    <div class="row g-2 g-2 mb-2">
        <fieldset class="col-md-6">
            <label for="place-location" class="form-label">
                Ubicación
            </label>
            <input
                type="text"
                class="form-control"
                id="place-location"
                value="{{ $movement->place->location->name ?? 'Sin ubicación' }} - {{ $movement->place->name ?? 'Sin lugar' }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-6">
            <label for="place-location" class="form-label">
                    Nro. Antiguo (si tuviese)
            </label>
            <input
                type="text"
                class="form-control"
                id="place-location"
                value="{{ $movement->inventory->old_number ?? 'Sin Número de Inventario Antiguo' }}"
                readonly
            >
        </fieldset>
    </div>

    <div class="row g-2 g-2 mb-2">
        <fieldset class="col-md-4">
            <label for="user-sender" class="form-label">
                Quién Entrega
            </label>
            <input
                type="text"
                class="form-control"
                id="user-sender"
                value="{{ $movement->senderUser->short_name ?? 'Sin información' }}"
                readonly
            >
        </fieldset>
        <fieldset class="col-md-4">
            <label for="user-reception-responsible" class="form-label">
                Quién Recepciona / Responsable
            </label>
            <input
                type="text"
                class="form-control"
                id="responsible"
                value="{{ optional($movement->responsibleUser)->short_name }}"
                readonly
            >
        </fieldset>
    </div>

    <div class="row g-2 g-2 mb-2">
        <fieldset class="col-md-4">
            <label for="status" class="form-label">
                Estado
            </label>
            <select
                class="form-select @error('status') is-invalid @enderror"
                id="status"
                wire:model.live.debounce.1500ms="status"                
            >
                <option value="">Seleccione un estado</option>
                <option value="1">Bueno</option>
                <option value="0">Regular</option>
                <option value="-1">Malo</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-8">
            <label for="observations" class="form-label">
                Observaciones
            </label>
            <input
                type="text"
                class="form-control @error('observations') is-invalid @enderror"
                id="observations"
                wire:model.live.debounce.1500ms="observations"
            >

            @error('observations')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="row">
        <div class="col text-right">
            <button
                class="btn btn-primary"
                wire:click="finish"
            >
                <i class="fas fa-check"></i> Recepcionar
            </button>
        </div>
    </div>
</div>
