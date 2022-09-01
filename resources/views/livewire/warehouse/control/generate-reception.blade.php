<div>
    @include('layouts.partials.flash_message')

    <div class="mt-2">
        <h4>Nuevo Ingreso: {{ $store->name }}</h4>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-sm-4 mb-0">
            <div class="input-group input-group-sm has-validation">
                <div class="input-group-prepend">
                    <span class="input-group-text">Fecha de Ingreso</span>
                </div>
                <input
                    class="form-control form-control-sm @error('date') is-invalid @enderror"
                    id="date"
                    wire:model.debounce.1500ms="date"
                    type="date"
                >
                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </fieldset>

        <fieldset class="form-group col-sm-5 mb-0">
            <div class="input-group input-group-sm has-validation">
                <div class="input-group-prepend">
                    <span class="input-group-text">Orden de Compra</span>
                </div>
                <input
                    type="text"
                    class="form-control form-control-sm @error('po_search') is-invalid @enderror"
                    placeholder="Ingresa el código"
                    wire:model.debounce.1500ms="po_search"
                >
                <div class="input-group-append">
                    <button
                        class="btn btn-sm btn-secondary"
                        wire:click="clearAll"
                        wire:target="getPurchaseOrder, clearAll"
                        wire:loading.attr="disabled"
                    >
                        Limpiar
                    </button>

                    <button
                        class="btn btn-sm btn-primary"
                        wire:click="getPurchaseOrder"
                        wire:target="getPurchaseOrder, clearAll"
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

        <fieldset class="form-group col-sm-3 mb-0">
            @if($request_form_id)
                <a
                    class="btn btn-sm btn-primary btn-block"
                    href="{{ route('request_forms.show', $request_form_id) }}"
                    target="_blank"
                >
                    <i class="fas fa-file-alt"></i> Formulario de Requerimiento #{{ $request_form_id }}
                </a>
            @endif
        </fieldset>
    </div>

    <hr>

    <div class="form-row">
        <fieldset class="form-group col-sm-2">
            <label for="po-code">Código OC</label>
            <input
                class="form-control form-control-sm @error('po_code') is-invalid @enderror"
                id="po-code"
                wire:model.debounce.1500ms="po_code"
                type="text"
                readonly
            >
            @error('po_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-2">
            <label for="po-date">Fecha OC</label>
            <input
                class="form-control form-control-sm @error('po_date') is-invalid @enderror"
                id="po-date"
                wire:model.debounce.1500ms="po_date"
                type="text"
                readonly
            >
            @error('po_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-8">
            <label for="supplier-name">Proveedor</label>
            <input
                class="form-control form-control-sm @error('supplier_name') is-invalid @enderror"
                id="supplier-name"
                wire:model.debounce.1500ms="supplier_name"
                type="text"
                readonly
            >
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-sm-2">
            <label for="guide-date">Fecha Guía</label>
            <input
                class="form-control form-control-sm @error('guide_date') is-invalid @enderror"
                id="guide-date"
                wire:model.debounce.1500ms="guide_date"
                type="date"
            >
            @error('guide_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-2">
            <label for="guide-number">Nro. Guía</label>
            <input
                class="form-control form-control-sm @error('guide_number') is-invalid @enderror"
                id="guide-number"
                wire:model.debounce.1500ms="guide_number"
                type="text"
            >
            @error('guide_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-3">
            <label for="program-id">Programa</label>
            <select
                wire:model.debounce.1500ms="program_id"
                id="program-id"
                class="form-control form-control-sm @error('program_id') is-invalid @enderror"
                @if($disabled_program)
                readonly disabled
                @endif
            >
                <option value="">Sin Programa</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">
                        {{ $program->name }}
                    </option>
                @endforeach
            </select>
            @error('program_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-5">
            <label for="note">Nota</label>
            <input
                class="form-control form-control-sm @error('note') is-invalid @enderror"
                id="note"
                wire:model.debounce.1500ms="note"
                type="text"
            >
            @error('note')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="signer-id" class="form-label">Firmante</label>
            @if($signer)
                <input
                    type="text"
                    class="form-control"
                    value="{{ $signer->full_name }}"
                    readonly
                >
            @else
                @livewire('users.search-user', [
                    'smallInput' => true,
                    'placeholder' => 'Ingrese un nombre',
                    'eventName' => 'signerId',
                    'tagId' => 'signer-id',
                ])

                <input
                    class="form-control @error('signer_id') is-invalid @enderror"
                    type="hidden"
                >

                @error('signer_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @endif
        </fieldset>
    </div>

    <div class="my-2">
        <h4>Productos</h4>
    </div>

    <input
        class="form-control @error('po_items') is-invalid @enderror"
        type="hidden"
    >
    @error('po_items')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center" max-width="100px">Código</th>
                    <th class="text-center" width="150px">Cant. Recibida</th>
                    <th>Producto</th>
                    <th class="text-center">Código Barra</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($po_items as $index => $po_item)
                <tr>
                    <td class="text-center">
                        @if($index_selected === $index && $po_item['can_edit'] && $request_form)
                            <label class="col-form-label-sm text-left my-0" for="rf-product-id">
                                Productos ONU
                            </label>
                            <select
                                wire:model="unspsc_product_code"
                                id="rf-product-id"
                                class="form-control form-control-sm @error('unspsc_product_code') is-invalid @enderror"
                            >
                                <option value="">Seleccione un Producto</option>
                                @foreach($request_form->itemRequestForms as $rf_product)
                                    <option value="{{ $rf_product->product->code }}">
                                        {{ $rf_product->product->code }}
                                        - {{ $rf_product->product->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            @if($po_item['unspsc_product_code'])
                                <small class="text-monospace">
                                    {{ $po_item['unspsc_product_code'] }}
                                </small>
                            @else
                                <small class="text-monospace">
                                    Sin Código ONU
                                </small>
                            @endif

                            @if ($errors->has('po_items.' . $index . '.unspsc_product_code'))
                                <br>
                                <small class="text-danger">
                                    <strong>{{ $errors->first('po_items.' . $index . '.unspsc_product_code') }}</strong>
                                </small>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($index_selected === $index)
                            <div class="form-row">
                                <fieldset class="form-group col-sm-12">
                                    <label class="col-form-label-sm text-left my-0" for="quantity">
                                        Cantidad Recibida
                                    </label>
                                    <input
                                        class="form-control form-control-sm @error('quantity') is-invalid @enderror"
                                        id="quantity"
                                        wire:model.debounce.1500ms="quantity"
                                        type="number"
                                        min="0"
                                    >
                                    <small class="form-text text-muted text-left">
                                        Cantidad Máxima: {{ $max_quantity }}
                                    </small>
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </fieldset>
                            </div>
                        @else
                            <div class="text-center">
                                {{ $po_item['quantity'] }} / {{ $po_item['max_quantity'] }}
                                <br>
                                <small class="text-muted">
                                    Cantidad Total: {{ $po_item['po_quantity'] }}
                                </small>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($index_selected === $index && $po_item['disabled_wre_product'] == false)
                            <label class="col-form-label-sm text-left my-0" for="unspsc-name">
                                Producto
                            </label>
                            <input
                                class="form-control form-control-sm"
                                id="unspsc-name"
                                value="{{ $po_item['unspsc_product_name'] }}"
                                type="text"
                                readonly
                            >
                            <div class="mt-1"></div>
                            <label class="col-form-label-sm text-left my-0" for="description">
                                Descripción
                            </label>
                            <input
                                class="form-control form-control-sm @error('description') is-invalid @enderror"
                                id="description"
                                wire:model.debounce.1500ms="description"
                                type="text"
                            >
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        @else
                            {{ $po_item['unspsc_product_name'] }}
                            <br>
                            <small>
                                @if($po_item['wre_product_id'])
                                    {{ $po_item['wre_product_name'] }}
                                @else
                                    {{ $po_item['description'] }}
                                @endif
                            </small>
                        @endif
                    </td>
                    <td>
                        @if($index_selected === $index && $po_item['disabled_wre_product'] == false)
                            <div class="form-check">
                                <input
                                    type="radio"
                                    id="new-product"
                                    value="1"
                                    wire:model="type_product"
                                    class="form-check-input"
                                >
                                <label class="form-check-label" for="new-product">Nuevo Producto</label>
                            </div>
                            <div class="form-check">
                                <input
                                    type="radio"
                                    id="select-product"
                                    wire:model="type_product"
                                    value="0"
                                    class="form-check-input"
                                >
                                <label class="form-check-label" for="select-product">Seleccionar producto</label>
                            </div>

                            @if($type_product == 0)
                                <label class="col-form-label-sm text-left my-0" for="search-product">
                                    Buscar Producto
                                </label>
                                <input
                                    class="form-control form-control-sm @error('search_product') is-invalid @enderror"
                                    type="text"
                                    id="search-product"
                                    placeholder="Ingrese nombre o código de barra"
                                    wire:model.debounce.1500ms="search_product"
                                >

                                <label class="col-form-label-sm text-left my-0" for="wre-product-id">
                                    Seleccionar un producto
                                </label>
                                <select
                                    wire:model="wre_product_id"
                                    id="wre-product-id"
                                    class="form-control form-control-sm @error('wre_product_id') is-invalid @enderror"
                                >
                                    <option value="">Seleccione Producto</option>
                                    @foreach($wre_products as $wre_product)
                                        <option value="{{ $wre_product->id }}">
                                            {{ $wre_product->product->code }} - {{ $wre_product->product->name }} - {{ $wre_product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <label class="col-form-label-sm text-left my-0" for="barcode">Código de Barra</label>
                                <input
                                    class="form-control form-control-sm @error('barcode') is-invalid @enderror"
                                    id="barcode"
                                    wire:model.debounce.1500ms="barcode"
                                    type="text"
                                >
                                @error('barcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            @endif
                        @else
                            <div class="text-center">
                                <small class="text-monospace">
                                    @if($po_item['barcode'])
                                        {{ $po_item['barcode'] }}
                                    @else
                                        -
                                    @endif
                                </small>
                                <br>
                                <span class="badge badge-secondary">
                                    @if($po_item['wre_product_id'])
                                        Producto seleccionado
                                    @else
                                        Crear Producto
                                    @endif
                                </span>
                            </div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($index_selected === $index)
                            <button
                                class="btn btn-sm btn-primary"
                                wire:click="updateProduct"
                            >
                                <i class="fas fa-edit"></i> Actualizar
                            </button>
                            <div class="my-1"></div>
                            <button
                                class="btn btn-sm btn-outline-secondary"
                                wire:click="resetInputProduct"
                                @if($index_selected === null)
                                    disabled
                                @endif
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
                @empty
                <tr class="text-center">
                    <td colspan="5">
                        <em>No hay productos</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col text-right">
            <button
                class="btn btn-success"
                wire:click="finish"
                wire:loading.attr="disabled"
                wire:target="finish"
                @if($po_code == null)
                    disabled
                @endif
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="finish"
                    aria-hidden="true"
                >
                </span>
                Terminar
            </button>
        </div>
    </div>
</div>
