<div>
    @section('title', 'Registrar Inventario')

    @can('Inventory: manager')
        @include('inventory.nav', [
            'establishment' => $establishment,
        ])
    @else
        @include('inventory.nav-user')
    @endcan

    <h6>Revisa el listado con los productos más comunes en oficinas</h6>

    <div class="row">
        <div class="col-12 col-sm-3">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered small">
                    <thead class="text-center">
                        <tr>
                            <th>Código ONU</th>
                            <th>Descripción del Bien</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center">43211507</th>
                            <td>Computador</td>
                        </tr>
                        <tr>
                            <th class="text-center">43211503</th>
                            <td>Notebook</td>
                        </tr>
                        <tr>
                            <th class="text-center">43211509</th>
                            <td>Tablet</td>
                        </tr>
                        <tr>
                            <th class="text-center">43211902</th>
                            <td>Monitor (LCD)</td>
                        </tr>
                        <tr>
                            <th class="text-center">43212110</th>
                            <td>Impresoras multifunción</td>
                        </tr>
                        <tr>
                            <th class="text-center">43212104</th>
                            <td>Impresora de tinta</td>
                        </tr>
                        <tr>
                            <th class="text-center">43212105</th>
                            <td>Impresora láser</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 col-sm-3">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered small">
                    <thead class="text-center">
                        <tr>
                            <th>Código ONU</th>
                            <th>Descripción del Bien</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center">56101703</th>
                            <td>Escritorio</td>
                        </tr>
                        <tr>
                            <th class="text-center">56112102</th>
                            <td>Silla trabajo</td>
                        </tr>
                        <tr>
                            <th class="text-center">56101504</th>
                            <td>Silla visita</td>
                        </tr>
                        <tr>
                            <th class="text-center">44111905</th>
                            <td>Pizarra</td>
                        </tr>
                        <tr>
                            <th class="text-center">44101603</th>
                            <td>Trituradora papel</td>
                        </tr>
                        <tr>
                            <th class="text-center">43191504</th>
                            <td>Teléfono</td>
                        </tr>
                        <tr>
                            <th class="text-center">52161505</th>
                            <td>Televisor</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 col-sm-3">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered small">
                    <thead class="text-center">
                        <tr>
                            <th>Código ONU</th>
                            <th>Descripción del Bien</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center">56121805</th>
                            <td>Repisa</td>
                        </tr>
                        <tr>
                            <th class="text-center">56101702</th>
                            <td>Kardex</td>
                        </tr>
                        <tr>
                            <th class="text-center">56112003</th>
                            <td>Cajonera</td>
                        </tr>
                        <tr>
                            <th class="text-center">56121702</th>
                            <td>Librero</td>
                        </tr>
                        <tr>
                            <th class="text-center">56121701</th>
                            <td>Estante</td>
                        </tr>
                        <tr>
                            <th class="text-center">44111510</th>
                            <td>Mueble colgante</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 col-sm-3">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered small">
                    <thead class="text-center">
                        <tr>
                            <th>Código ONU</th>
                            <th>Descripción del Bien</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center">48101711</th>
                            <td>Dispensador de agua</td>
                        </tr>
                        <tr>
                            <th class="text-center">40101701</th>
                            <td>Aires acondicionados</td>
                        </tr>
                        <tr>
                            <th class="text-center">52141510</th>
                            <td>Ventilador</td>
                        </tr>
                        <tr>
                            <th class="text-center">52141802</th>
                            <td>Calefactor</td>
                        </tr>
                        <tr>
                            <th class="text-center">52141526</th>
                            <td>Cafetera</td>
                        </tr>
                        <tr>
                            <th class="text-center">52141523</th>
                            <td>Hervidor</td>
                        </tr>
                        <tr>
                            <th class="text-center">48101714</th>
                            <td>Termo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <hr>

    <h4 class="mb-3">
        {{ $establishment->name }}: Registrar Inventario
    </h4>

    <h6 class="mt-3">
        <strong>
            Datos del Producto
        </strong>
    </h6>

    <div class="row g-2">
        <fieldset class="form-group col-sm-4">
            <label for="product-search">
                Buscar Producto o Servicio
            </label>
            <input
                wire:model.live.debounce.500ms="search_product"
                id="product-search"
                class="form-control"
                type="text"
                placeholder="Ej: Computador"
                autocomplete="off"
            >
        </fieldset>

        <fieldset class="form-group col-sm-8">
            <label for="product-id">
                *Debe Seleccionar un Producto o Servicio del listado (obligatorio)
            </label>
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

    <div class="row g-2 mb-2">
        <fieldset class="col-md-12">
            <label for="description" class="form-label">
                Descripción <small>(especificaciones técnicas)</small>
            </label>
            <input
                wire:model.live.debounce.500ms="description"
                type="text"
                class="form-control @error('description') is-invalid @enderror"
                id="description"
                placeholder="Ej: 2GB de RAM y 256 Disco Duro"
                autocomplete="off"
            >
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="row g-2 mb-2">
        <fieldset class="col-md-3">
            <label for="number-inventory" class="form-label">
                *Nro. de Inventario
            </label>
            <input
                wire:model.live.debounce.500ms="number_inventory"
                type="text"
                class="form-control @error('number_inventory') is-invalid @enderror"
                id="number-inventory"
                placeholder="Ej: 12345-67-89"
                autocomplete="off"
            >
            <button
                    class="btn btn-primary"
                    wire:click="generateCode"
                    wire:target="generateCode"
                    wire:loading.attr="disabled"
                >
                <span
                        wire:loading.remove
                        wire:target="generateCode"
                    >
                    <i class="fas fa-qrcode"></i>
                </span>
                Generar
            </button>
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
                wire:model.live.debounce.500ms="brand"
                type="text"
                class="form-control @error('brand') is-invalid @enderror"
                id="brand"
                placeholder="Ej: Lenovo"
                autocomplete="off"
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
                wire:model.live.debounce.500ms="model"
                type="text"
                class="form-control @error('model') is-invalid @enderror"
                id="model"
                placeholder="Ej: All In One"
                autocomplete="off"
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
                wire:model.live.debounce.500ms="serial_number"
                type="text"
                class="form-control @error('serial_number') is-invalid @enderror"
                id="serial-number"
                placeholder="Ej: 123456789-01234-56789"
                autocomplete="off"
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

    <div class="row g-2 mb-2">
        <fieldset class="col-md-3">
            <label for="status" class="form-label">
                *Estado
            </label>
            <select
                class="form-control @error('status') is-invalid @enderror"
                id="status"
                wire:model.live.debounce.500ms="status"
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
                wire:model.live.debounce.500ms="observations"
                type="text"
                class="form-control @error('observations') is-invalid @enderror"
                id="observations"
                placeholder="Ej: La computadora tiene un boton dañado"
                autocomplete="off"
            >
            @error('observations')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="row g-2 mt-4">
        <div class="form-group col-md-12">
            <label for="type">Tipo:</label>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    wire:model.live="type"
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
                    wire:model.live="type"
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
                    wire:model.live="type"
                    id="option-type-3"
                    value="3"
                >
                <label class="form-check-label" for="option-type-3">
                    Soy Usuario y Responsable
                </label>
            </div>
            @can('Inventory: manager')
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    wire:model.live="type"
                    id="option-type-4"
                    value="4"
                >
                <label class="form-check-label" for="option-type-4">
                    Soy Encargada de Inventario
                </label>
            </div>
            @endcan
        </div>
    </div>

    <div class="row g-2">
        <fieldset class="col-md-4">
            <label for="user-using-id" class="form-label">
                *Usuario
            </label>
            @if($type == 2)
                @livewire('users.search-user', [
                    'placeholder' => 'Ingrese un nombre',
                    'eventName' => 'myUserUsingId',
                    'tagId' => 'user-using-id',
                    'bt' => 4,
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

            @elseif($type == 4)
                @livewire('users.search-user', [
                    'placeholder' => 'Ingrese un nombre',
                    'eventName' => 'myUserUsingId',
                    'tagId' => 'user-using-id',
                    'bt' => 4,
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
            <label for="user-responsible-id" class="form-label">
                *Responsable
            </label>
            @if($type == 1)
                @livewire('users.search-user', [
                    'placeholder' => 'Ingrese un nombre',
                    'eventName' => 'myUserResponsibleId',
                    'tagId' => 'user-responsible-id',
                    'bt' => 4,
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

            @elseif($type == 4)
                @livewire('users.search-user', [
                    'placeholder' => 'Ingrese un nombre',
                    'eventName' => 'myUserResponsibleId',
                    'tagId' => 'user-responsible-id',
                    'bt' => 4,
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
                *Ubicación
            </label>

            @livewire('places.find-place', [
                'tagId' => 'place-id',
                'placeholder' => 'Ingrese una ubicación o cod. arq.',
                'establishment' => $establishment,
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
        <div class="row g-2 mb-2">
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
                        wire:model.live.debounce.500ms="po_search"
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
                    wire:model.live.debounce.500ms="po_date"
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
                        <i class="fas fa-file-alt"></i> FR Folio #{{ $request_form->folio }}
                    </a>
                </fieldset>
            @endif
        </div>

        <div class="row g-2 mb-2">
            <fieldset class="col-md-2">
                <label for="useful-life" class="form-label">
                    Vida útil
                </label>
                <input
                    wire:model.live.debounce.500ms="useful_life"
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

            <fieldset class="col-md-2">
                <label for="depreciation" class="form-label">
                    Depreciación
                </label>
                <input
                    type="text"
                    class="form-control @error('depreciation') is-invalid @enderror"
                    id="depreciation"
                    wire:model="depreciation"
                    autocomplete="off"
                >
                @error('depreciation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="col-md-3">
                <label for="cost-center" class="form-label">
                    Cuenta contable
                </label>
                <select
                    type="text"
                    class="form-control @error('accounting_code_id') is-invalid @enderror"
                    id="cost-center"
                    wire:model.live="accounting_code_id"
                >
                    <option value="">Seleccione cuenta contable</option>
                    @foreach($accountingCodes as $accountingCode)
                        <option value="{{ $accountingCode->id }}">
                        {{ $accountingCode->id }} - {{ $accountingCode->description }}
                        </option>
                    @endforeach
                </select>
                @error('accounting_code_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="col-md-2">
                <label for="po-price" class="form-label">
                    Precio del Producto
                </label>
                <input
                    wire:model.live.debounce.500ms="po_price"
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


            <fieldset class="col-md-3">
                <label for="deliver-date" class="form-label">
                    Fecha de Entrega
                </label>
                <input
                    wire:model.live.debounce.500ms="deliver_date"
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

    <div class="row g-2 mt-3">
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
