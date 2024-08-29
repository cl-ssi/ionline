<div>
    <h4 class="my-2">Revisar Productos</h4>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 100px">Código</th>
                    <th>Producto o Servicio</th>
                    <th class="text-center" style="width: 250px" >Cantidad</th>
                    <th class="text-center">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr>
                    <td>
                        @if($index === $indexEdit)
                            <fieldset class="form-group">
                                <label class="my-0" for="barcode">Código de Barra</label>
                                <input
                                    class="form-control form-control-sm @error('barcode') is-invalid @enderror"
                                    type="text"
                                    wire:model.live.debounce.1500ms="barcode"
                                    id="barcode"
                                    readonly
                                >
                                @error('barcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </fieldset>
                        @else
                            <div class="text-center">
                                <small class="text-monospace">
                                    {{ $item['unspsc_product_code'] }}
                                </small>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($index === $indexEdit)
                            @if($can_edit)
                                <div class="form-group">
                                    <label class="my-0" for="type-product">
                                        Tipo de Producto
                                    </label>
                                    <select
                                        wire:model.live.debounce.1500ms="type_wre_product"
                                        id="type-product"
                                        class="form-control form-control-sm"
                                    >
                                        <option value="1">
                                            Crear nuevo
                                        </option>
                                        <option value="2">
                                            Seleccionar un producto
                                        </option>
                                    </select>
                                </div>
                            @endif

                            @if($type_wre_product == 2)
                                <div class="form-group">
                                    <label class="my-0" for="wre-product-id">
                                        Productos similares
                                    </label>
                                    <select
                                        class="form-control form-control-sm @error('selected_wre_product_id') is-invalid @enderror"
                                        id="wre-product-id"
                                        wire:model.live.debounce.1500ms="selected_wre_product_id"
                                    >
                                        <option value="">Selecciona un producto</option>
                                        @foreach($wre_products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->product->name }} - {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selected_wre_product_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @else

                                <fieldset class="form-group">
                                    <label class="my-0" for="search-product">
                                        Buscar Producto o Servicio
                                    </label>
                                    <input
                                        class="form-control form-control-sm"
                                        type="text"
                                        id="search-product"
                                        wire:model.live.debounce.1500ms="search_product"
                                    >
                                </fieldset>

                                <fieldset class="form-group">
                                    <label class="my-0" for="product-id">
                                        Selecciona Producto o Servicio
                                    </label>
                                    <input
                                        class="form-control form-control-sm @error('unspsc_product_id') is-invalid @enderror"
                                        type="hidden"
                                    >
                                    @livewire('unspsc.product-search', ['smallInput' => true])
                                    @error('unspsc_product_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </fieldset>

                                <fieldset class="form-group">
                                    <label class="my-0" for="description">Descripción</label>
                                    <input
                                        class="form-control form-control-sm @error('description') is-invalid @enderror"
                                        type="text"
                                        wire:model.live.debounce.1500ms="description"
                                        id="description"
                                    >
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </fieldset>
                            @endif
                        @else
                            {{ $item['unspsc_product_name'] }}
                            <br>
                            <small>
                                @if($item['barcode'])
                                    <span class="text-monospace">
                                        {{ $item['barcode'] }}
                                        -
                                    </span>
                                @endif
                                {{ $item['description'] }}
                            </small>
                            <br>
                            @if($item['type_wre_product'])
                                <span class="badge badge-secondary">
                                    @switch($item['type_wre_product'])
                                        @case(1)
                                            Producto nuevo
                                        </span>
                                            @break
                                        @case(2)
                                            Seleccionado un Producto existente
                                            @break
                                        @default
                                    @endswitch
                                </span>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($index === $indexEdit)
                            <fieldset class="form-group">
                                <label class="my-0" for="quantity">Cantidad Enviada</label>
                                <input
                                    class="form-control form-control-sm"
                                    type="number"
                                    value="{{ $item['quantity'] }}"
                                    id="quantity"
                                    readonly
                                >
                            </fieldset>

                            <fieldset class="form-group">
                                <label class="my-0" for="quantity-received">Cantidad Recibida</label>
                                <input
                                    class="form-control form-control-sm @error('quantity_received') is-invalid @enderror"
                                    type="number"
                                    wire:model.live.debounce.1500ms="quantity_received"
                                    id="quantity-received"
                                >
                                @error('quantity_received')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </fieldset>

                            <fieldset class="form-group">
                                <label class="my-0" for="quantity-return">Cantidad Devolver</label>
                                <input
                                    class="form-control form-control-sm"
                                    type="number"
                                    value="{{ $item['quantity_return'] }}"
                                    id="quantity-return"
                                    readonly
                                >
                            </fieldset>
                        @else
                            <div class="text-center">
                                Enviada: {{ $item['quantity'] }}
                                <br>
                                Recibida: {{ $item['quantity_received'] }}
                                <br>
                                Devolver: {{ $item['quantity_return'] }}
                            </div>
                        @endif
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
                        @if($index === $indexEdit)
                            <button
                                class="btn btn-primary"
                                wire:click="updateProduct"
                                @if(!isset($indexEdit)) disabled @endif
                            >
                                Actualizar
                            </button>
                            <div class="my-1"></div>
                            <button
                                class="btn btn-outline-secondary"
                                wire:click="resetInput"
                                @if(!isset($indexEdit)) disabled @endif
                            >
                                Cancelar
                            </button>
                        @else
                            <button
                                class="btn btn-sm btn-primary"
                                wire:click="editProduct({{ $index }})"
                            >
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        @endif
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
                    wire:model.live.debounce.1500ms="return_note"
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
            @endif
        </div>
    </div>
</div>
