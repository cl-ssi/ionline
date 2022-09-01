<div>
    @section('title', 'Gestión de Facturas')

    @include('warehouse.nav')

    <h4 class="mb-3">
        Gestión de Facturas
    </h4>

    <div class="form-row mb-3">
        <fieldset class="form-group col-sm-5 mb-0">
            <label for="search">Buscar OC</label>
            <div class="input-group">
                <input
                    type="text"
                    wire:model.debounce.1500ms="search"
                    id="search"
                    class="form-control"
                    placeholder="Ingresa el número de la OC"
                >
                <div class="input-group-append">
                    <button
                        class="btn btn-primary"
                        wire:target="searchPurchaseOrder"
                        wire:loading.attr="disabled"
                        wire:click="searchPurchaseOrder"
                    >
                        <span
                            class="spinner-border spinner-border-sm"
                            role="status"
                            wire:loading
                            wire:target="searchPurchaseOrder"
                            aria-hidden="true"
                        >
                        </span>

                        <span wire:loading.remove wire:target="searchPurchaseOrder">
                            <i class="fas fa-search"></i>
                        </span>

                        Buscar
                    </button>
                </div>
            </div>
        </fieldset>
    </div>


    <input
        class="form-control @error('selected_controls') is-invalid @enderror"
        type="hidden"
    >
    @error('selected_controls')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 100px"></th>
                    <th>Ingreso</th>
                    <th class="text-center">Fecha Ingreso</th>
                    <th>Facturas</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                    wire:target="searchPurchaseOrder"
                >
                    <td class="text-center" colspan="4">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($controls as $control)
                    <tr wire:loading.remove wire:target="searchPurchaseOrder">
                        <td class="text-center">
                            <div class="form-check" wire:loading.remove wire:target="searchPurchaseOrder">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    wire:model.debounce.9000ms="selected_controls"
                                    value={{ $control->id }}
                                    id="option-{{ $control->id }}"
                                >
                            </div>
                        </td>
                        <td>
                            <b>Ingreso #{{ $control->id }}</b>
                            <br>
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    @foreach($control->items as $controlItem)
                                    <tr>
                                        <td>{{ $controlItem->quantity }}</td>
                                        <td>
                                            {{ $controlItem->product->product->name }}
                                            <br>
                                            <small>
                                                {{ $controlItem->product->name }}
                                            </small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        <td class="text-center">
                            {{ $control->date->format('Y-m-d') }}
                        </td>
                        <td>
                            @foreach($control->invoices as $invoice)
                                <li>{{ $invoice->number }}</li>
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr class="text-center" wire:loading.remove wire:target="searchPurchaseOrder">
                        <td colspan="4">
                            <em>No hay ingresos</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-row g-2">
        <fieldset class="form-group col-sm-3">
            <label for="invoice-number">Número Factura</label>
            <input
                class="form-control @error('number') is-invalid @enderror"
                id="invoice-number"
                wire:model.debounce.1500ms="number"
                type="text"
            >
            @error('number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-3">
            <label for="invoice-date">Fecha Factura</label>
            <input
                class="form-control @error('date') is-invalid @enderror"
                id="invoice-date"
                wire:model.debounce.1500ms="date"
                type="date"
            >
            @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-4">
            <label for="invoice-{{ $iteration }}">Archivo Factura</label>
            <input
                class="form-control form-control-file @error('file') is-invalid @enderror"
                type="file"
                wire:model.debounce.1500ms="file"
                id="invoice-{{ $iteration }}"
            >
            @error('file')
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
                wire:target="save"
                wire:loading.attr="disabled"
                wire:click="save"
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="save"
                    aria-hidden="true"
                >
                </span>

                <span wire:loading.remove wire:target="save">
                    <i class="fas fa-save"></i>
                </span>

                Guardar
            </button>
        </div>
    </div>

</div>
