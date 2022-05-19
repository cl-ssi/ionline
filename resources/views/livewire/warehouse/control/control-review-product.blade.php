<div>

    <hr>
    <h4 class="my-2">Editar: {{ $indexEdit }}</h4>

    <div class="form-row">
        <fieldset class="form-group col-md-3">
            <label for="search-product">Buscar Producto o Servicio</label>
            <input
                class="form-control"
                type="text"
                id="search-product"
                wire:model.debounce.600ms="search_product"
            >
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="product-id">Selecciona Producto o Servicio</label>
            <input
                class="form-control @error('unspsc_product_id') is-invalid @enderror"
                type="hidden"
            >
            @livewire('unspsc.product-search')
            @error('unspsc_product_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-5">
            <label for="description">Descripción</label>
            <input
                class="form-control @error('description') is-invalid @enderror"
                type="text"
                wire:model="description"
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
                class="form-control @error('barcode') is-invalid @enderror"
                type="text"
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

        <fieldset class="form-group col-md-2">
            <label for="quantity">Cantidad</label>
            <input
                class="form-control @error('quantity') is-invalid @enderror"
                type="number"
                wire:model="quantity"
                id="quantity"
                readonly
            >
            @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="quantity-received">Cantidad Recibida</label>
            <input
                class="form-control @error('quantity_received') is-invalid @enderror"
                type="number"
                wire:model="quantity_received"
                id="quantity-received"
            >
            @error('quantity_received')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12 text-right">
            <button
                class="btn btn-primary"
                wire:click="updateProduct"
                @if(!isset($indexEdit)) disabled @endif
            >
                Actualizar
            </button>
            <button
                class="btn btn-primary"
                wire:click="resetInput"
                @if(!isset($indexEdit)) disabled @endif
            >
                Cancelar
            </button>
        </div>
    </div>

    <hr>
    <h4 class="my-2">Revisar Productos</h4>

    <div class="table-responsive">
        <table class="table small table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Código de Barra</th>
                    <th>Producto o Servicio</th>
                    <th>Programa</th>
                    <th class="text-center">Enviados</th>
                    <th class="text-center">Recibidos</th>
                    <th class="text-center">Devolver</th>
                    <th class="text-center">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr>
                    <td class="text-center">
                        <small class="text-monospace">
                            {{ $item['barcode'] }}
                        </small>
                    </td>
                    <td>
                        {{ $item['unspsc_product_name'] }}
                        <br>
                        <small>{{ $item['description'] }}</small>
                    </td>
                    <td>{{ $item['program_name'] }}</td>
                    <td class="text-center">
                        {{ $item['quantity'] }}
                    </td>
                    <td class="text-center">
                        {{ $item['quantity_received'] }}
                    </td>
                    <td class="text-center">
                        {{ $item['quantity_return'] }}
                    </td>
                    <td class="text-center">
                        @switch($item['status'])
                            @case(0)
                                <span class="badge badge-danger">
                                    No recibida
                                </span>
                                @break
                            @case(-1)
                                <span class="badge badge-warning">
                                   Recepción parcial
                                </span>
                                @break
                            @case(1)
                                <span class="badge badge-success">
                                    Recepción completa
                                </span>
                                @break
                            @endswitch
                    </td>
                    <td class="text-center">
                        <button
                            class="btn btn-sm btn-outline-secondary"
                            wire:click="editProduct({{ $index }})"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($generate_return)
        <h5>Detalles de Devolución</h5>

        <div class="form-row">
            <fieldset class="form-group col-md-4">
                <label for="generate-return">Generar Devolución</label>
                <input
                    class="form-control"
                    type="text"
                    value="{{ ($generate_return) ? 'SI' : 'NO' }}"
                    id="generate-return"
                    readonly
                >
            </fieldset>

            <fieldset class="form-group col-md-4">
                <label for="store-return">Bodega que recibe la Devolución</label>
                <input
                    class="form-control"
                    type="text"
                    value="{{ optional($control->originStore)->name }}"
                    id="store-return"
                    readonly
                >
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-md-12">
                <label for="return-note">Nota de Devolución</label>
                <input
                    class="form-control @error('return_note') is-invalid @enderror"
                    type="text"
                    wire:model="return_note"
                    id="return-note"
                >
                @error('return_note')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>
        </div>
    @endif

    <div class="form-row">
        <div class="form-group col-md-12 text-right">
            @if(!$control->isConfirmed())
                <button
                    class="btn btn-success"
                    wire:click="finish"
                >
                    <i class="fas fa-check"></i> Terminar
                </button>
            @else
                <a
                    class="btn btn-success"
                    href="{{ route('warehouse.controls.index', ['store' => $store, 'type' => 'receiving' ]) }}"
                >
                    <i class="fas fa-check"></i> Terminar
                </a>
            @endif
        </div>
    </div>
</div>
