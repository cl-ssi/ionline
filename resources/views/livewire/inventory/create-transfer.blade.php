<div>
    @section('title', 'Generar Traspaso')

    @include('inventory.nav-user')
    <style>
        .bg-image-HAH {
            width: 340px;
            height: 340px;
            background-image: url('{{ asset('images/inventario_HAH_nuevo.png') }}');
            background-size: 340px;
        }

        .bg-image-SST {
            width: 340px;
            height: 340px;
            background-image: url('{{ asset('images/inventario_SST_nuevo.png') }}');
            background-size: 340px;
        }

        .qr {
            padding-top: 111px;
            padding-left: 6px;
        }

        .code {
            padding-top: 8px;
            text-align: center;
            font-size: 19px;
            font-weight: bold;
        }
    </style>

    <div class="bg-image-{{ $inventory->establishment->alias }} mb-3">
        <div class="qr text-center">
            {!! $inventory->qr !!}
        </div>
        <div class="code">
            {{ $inventory->number }}
        </div>
    </div>

    <h4 class="mb-3">
        Generar Traspaso
    </h4>

    <div class="row g-2 g-2 mb-2">
        <fieldset class="col-md-4">
            <label for="number" class="form-label">
                Nro. Inventario
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="number"
                value="{{ $inventory->number }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-4">
            <label for="product" class="form-label">
                Producto
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="product"
                value="{{ optional($inventory->unspscProduct)->name }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-4">
            <label for="description" class="form-label">
                Descripción <small>(especificación técnica)</small>
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="description"
                value="{{-- $inventory->product->name --}}"
                readonly
            >
        </fieldset>
    </div>

    <div class="row g-2 g-2 mb-2">
        <fieldset class="col-md-4">
            <label for="number" class="form-label">
                Marca
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="brand"
                value="{{ $inventory->brand }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-4">
            <label for="model" class="form-label">
                Modelo
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="model"
                value="{{ $inventory->model }}"
                readonly
            >
        </fieldset>

        <fieldset class="col-md-4">
            <label for="serial_number" class="form-label">
                Número de serie
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="serial_number"
                value="{{ $inventory->serial_number }}"
                readonly
            >
        </fieldset>
    </div>

    @livewire('inventory.register-movement', ['inventory' => $inventory])

    @livewire('inventory.update-movement', ['inventory' => $inventory])

    <hr>

    @livewire('inventory.removal-request', ['inventory' => $inventory])
    <h5 class="mt-3">Historial del ítem</h5>

    @livewire('inventory.movement-index', ['inventory' => $inventory])
</div>
