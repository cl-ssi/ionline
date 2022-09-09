<div>
    @section('title', 'Registrar Inventario')

    @include('inventory.nav-user')

    <h4 class="mb-3">
        Registrar Inventario
    </h4>

    <h6 class="mt-3">
        <strong>
            Datos del Producto
        </strong>
    </h6>

    <div class="form-row g-2">
        <fieldset class="form-group col-sm-4">
            <label for="description">Buscar Producto o Servicio</label>
            <input
                wire:model.debounce.500ms="search_product"
                id="product-search"
                class="form-control"
                type="text"
                placeholder="Ej: Computador"
            >
        </fieldset>

        <fieldset class="form-group col-sm-8">
            <label for="product-id">Debe Seleccionar un Producto o Servicio del listado (obligatorio)</label>
            @livewire('unspsc.product-search', ['showCode' => true])
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

    <div class="form-row g-2 mb-2">
        <fieldset class="col-md-12">
            <label for="description" class="form-label">
                Descripción <small>(especificaciones técnicas)</small>
            </label>
            <input
                wire:model.debounce.500ms="description"
                type="text"
                class="form-control @error('description') is-invalid @enderror"
                id="description"
                placeholder="Ej: 2GB de RAM y 256 Disco Duro"
            >
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row g-2 mb-2">
        <fieldset class="col-md-3">
            <label for="number-inventory" class="form-label">
                Nro. de Inventario
            </label>
            <input
                wire:model.debounce.500ms="number_inventory"
                type="text"
                class="form-control @error('number_inventory') is-invalid @enderror"
                id="number-inventory"
                placeholder="Ej: 12345-67-89"
            >
            @error('number_inventory')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-3">
            <label for="brand" class="form-label">
                Marca
            </label>
            <input
                wire:model.debounce.500ms="brand"
                type="text"
                class="form-control @error('brand') is-invalid @enderror"
                id="brand"
                placeholder="Ej: Lenovo"
            >
            @error('brand')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-3">
            <label for="model" class="form-label">
                Modelo
            </label>
            <input
                wire:model.debounce.500ms="model"
                type="text"
                class="form-control @error('model') is-invalid @enderror"
                id="model"
                placeholder="Ej: All In One"
            >
            @error('model')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="col-md-3">
            <label for="serial-number" class="form-label">
                Número de Serial
            </label>
            <input
                wire:model.debounce.500ms="serial_number"
                type="text"
                class="form-control @error('serial_number') is-invalid @enderror"
                id="serial-number"
                placeholder="Ej: 123456789-01234-56789"
            >
            @error('serial_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <h6 class="mt-4">
        <strong>
            Estado del producto
        </strong>
    </h6>

    <div class="form-row g-2 mb-2">
        <fieldset class="col-md-3">
            <label for="status" class="form-label">
                Estado
            </label>
            <select
                class="form-control @error('status') is-invalid @enderror"
                id="status"
                wire:model.debounce.500ms="status"
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

        <fieldset class="col-md-9">
            <label for="observations" class="form-label">
                Observaciones
            </label>
            <input
                wire:model.debounce.500ms="observations"
                type="text"
                class="form-control @error('observations') is-invalid @enderror"
                id="observations"
                placeholder="Ej: La computadora tiene un boton dañado"
            >
            @error('observations')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row g-2 mt-4">
        <div class="form-group col-md-12">
            <label for="type">Tipo:</label>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    wire:model="type"
                    id="option-type-1"
                    value="1"
                >
                <label class="form-check-label" for="option-type-1">
                    Soy Usuario
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    wire:model="type"
                    id="option-type-2"
                    value="2"
                >
                <label class="form-check-label" for="option-type-2">
                    Soy Responsable
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    wire:model="type"
                    id="option-type-3"
                    value="3"
                >
                <label class="form-check-label" for="option-type-3">
                    Soy Usuario y Responsable
                </label>
            </div>
        </div>
    </div>

    <div class="form-row g-2">
        <fieldset class="col-md-4">
            <label for="user-using-id" class="form-label">Usuario</label>
            @if($type == 2)
                @livewire('users.search-user', [
                    'placeholder' => 'Ingrese un nombre',
                    'eventName' => 'myUserUsingId',
                    'tagId' => 'user-using-id',
                ])

                <input
                    class="form-control @error('user_using_id') is-invalid @enderror"
                    type="hidden"
                >

                @error('user_using_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @else
                <input
                    type="text"
                    class="form-control"
                    id="user-usign-date"
                    value="{{ auth()->user()->short_name }}"
                    readonly
                >
            @endif
        </fieldset>

        <fieldset class="col-md-4">
            <label for="user-responsible-id" class="form-label">Responsable</label>
            @if($type == 1)
                @livewire('users.search-user', [
                    'placeholder' => 'Ingrese un nombre',
                    'eventName' => 'myUserResponsibleId',
                    'tagId' => 'user-responsible-id',
                ])

                <input
                    class="form-control @error('user_responsible_id') is-invalid @enderror"
                    type="hidden"
                >

                @error('user_responsible_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @else
                <input
                    type="text"
                    class="form-control"
                    id="user-responsable-id"
                    value="{{ auth()->user()->short_name }}"
                    readonly
                >
            @endif
        </fieldset>

        <fieldset class="col-md-4">
            <label for="place-id" class="form-label">
                Ubicación
            </label>

            @livewire('places.find-place', [
                'tagId' => 'place-id',
                'placeholder' => 'Ingrese una ubicación'
            ])

            <input
                class="form-control @error('place_id') is-invalid @enderror"
                type="hidden"
            >

            @error('place_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <h6 class="mt-4">
        <a class="link-primary" role="button" wire:click="collapse">
            Opciones Avanzadas
        </a>
    </h6>

    <div class="@if(!$collapse) d-none @endif">
        <div class="form-row g-2 mb-2">
            <fieldset class="col-md-6">
                <label for="po-search" class="form-label">
                    Orden de Compra
                </label>
                <div class="input-group has-validation">
                    <input
                        class="form-control @error('po_search') is-invalid @enderror"
                        type="text"
                        id="po-search"
                        placeholder="Ingresa el código"
                        wire:model.debounce.500ms="po_search"
                    >
                    <div class="input-group-append">
                        <button
                            class="btn btn-sm btn-secondary"
                            wire:click="clearInputAdvantage({{ true }})"
                            wire:target="getPurchaseOrder, clearInputAdvantage"
                            wire:loading.attr="disabled"
                        >
                            Limpiar
                        </button>

                        <button
                            class="btn btn-sm btn-primary"
                            wire:click="getPurchaseOrder"
                            wire:target="getPurchaseOrder, clearInputAdvantage"
                            wire:loading.attr="disabled"
                        >
                            <span
                                class="spinner-border spinner-border-sm"
                                role="status"
                                wire:loading
                                wire:target="getPurchaseOrder"
                                aria-hidden="true"
                            >
                            </span>

                            <span
                                wire:loading.remove
                                wire:target="getPurchaseOrder"
                            >
                                <i class="fas fa-search"></i>
                            </span>
                            Buscar
                        </button>
                    </div>
                    @error('po_search')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                @if($error)
                    <div class="d-block my-0 py-0">
                        <small class="text-danger">
                            <b>{{ $msg }}</b>
                        </small>
                    </div>
                @endif
            </fieldset>

            <fieldset class="col-md-2">
                <label for="po-date" class="form-label">
                    Fecha de OC
                </label>
                <input
                    wire:model.debounce.500ms="po_date"
                    type="text"
                    class="form-control @error('po_date') is-invalid @enderror"
                    id="po-date"
                    disabled
                >
                @error('po_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            @if($request_form)
                <fieldset class="col-md-4">
                    <label for="fr" class="form-label">
                        Formulario de Requerimiento
                    </label>
                    <a
                        class="btn btn-primary btn-block"
                        href="{{ route('request_forms.show', $request_form->id) }}"
                        target="_blank"
                    >
                        <i class="fas fa-file-alt"></i> Formulario de Requerimiento #{{ $request_form->id }}
                    </a>
                </fieldset>
            @endif
        </div>

        <div class="form-row g-2 mb-2">
            <fieldset class="col-md-4">
                <label for="po-price" class="form-label">
                    Precio del Producto
                </label>
                <input
                    wire:model.debounce.500ms="po_price"
                    type="text"
                    class="form-control @error('po_price') is-invalid @enderror"
                    id="po-price"
                    placeholder="Ej: 1234.56"
                >
                @error('po_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="col-md-4">
                <label for="useful-life" class="form-label">
                    Vida útil
                </label>
                <input
                    wire:model.debounce.500ms="useful_life"
                    type="number"
                    class="form-control @error('useful_life') is-invalid @enderror"
                    id="useful-life"
                    placeholder="Ej: 1"
                >
                @error('useful_life')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="col-md-4">
                <label for="deliver-date" class="form-label">
                    Fecha de Entrega
                </label>
                <input
                    wire:model.debounce.500ms="deliver_date"
                    type="date"
                    class="form-control @error('deliver_date') is-invalid @enderror"
                    id="deliver-date"
                    placeholder="Ej: 123456789-01234-56789"
                >
                @error('deliver_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>
        </div>
    </div>

    <div class="form-row mt-3">
        <div class="col text-right">
            <button
                class="btn btn-primary"
                wire:click="register"
            >
                <i class="fas fa-plus"></i> Registrar
            </button>
        </div>
    </div>

</div>
