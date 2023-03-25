<div>
    <h4 class="mb-3">
        Gestión de Facturas: {{ $store->name }}
    </h4>

    @include('layouts.partials.flash_message')

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
                    <th class="text-center">Acta Ingreso Bodega</th>
                    <th>Facturas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                    wire:target="searchPurchaseOrder"
                >
                    <td class="text-center" colspan="6">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($controls as $control)
                    <tr wire:loading.remove wire:target="searchPurchaseOrder">
                        <td class="text-center">
                            <div
                                class="form-check"
                                wire:loading.remove
                                wire:target="searchPurchaseOrder"
                            >
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
                            <b>Ingreso #{{ $control->id }} - OC: {{ $control->po_code }}</b>
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
                        <td class="text-center" nowrap>
                            {{ $control->date->format('Y-m-d') }}
                        </td>
                        <td class="text-center">
                            @if($control->technicalSignature && $control->technicalSignature->signaturesFlows->first()->isSigned())
                                <a
                                    href="{{ route('documents.signatures.showPdf', [
                                        $control->technicalSignature->signaturesFlows->first()->signaturesFile->id, time()
                                    ]) }}"
                                    class="btn btn-sm btn-outline-success" target="_blank"
                                    title="Ver documento"
                                >
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @elseif($control->isConfirmed())
                                <a
                                    href="{{ route('warehouse.control.pdf', [
                                        'store' => $store,
                                        'control' => $control,
                                        'act_type' => 'reception'
                                    ]) }}"
                                    class="btn btn-sm btn-outline-secondary"
                                    target="_blank"
                                    title="Acta Recepción Técnica"
                                >
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            @forelse($control->invoices as $invoice)
                            <a
                                href="{{ $invoice->link }}"
                                class="btn btn-sm mb-1 @if($control->completed_invoices) btn-success @else btn-danger @endif"
                                target="_blank"
                                title="Ver Factura {{ $invoice->number }}"
                            >
                                <i class="fas fa-file-pdf"></i> {{ $invoice->number }}
                            </a>
                            <br>
                            @empty
                                <small>
                                    <b>Sin facturas</b>
                                </small>
                            @endforelse
                        </td>
                        <td class="text-center">
                            <button
                                class="btn btn-sm @if($control->completed_invoices === true) btn-success @else btn-outline-success @endif"
                                wire:click="markCompletedInvoices({{ $control }})"
                                title="Todas las facturas recepcionadas"
                                @if($control->completed_invoices) disabled @endif
                            >
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr
                        class="text-center"
                        wire:loading.remove
                        wire:target="searchPurchaseOrder"
                    >
                        <td colspan="6">
                            <em>No hay ingresos</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-row g-2">
        <fieldset class="form-group col-sm-2">
            <label for="invoice-number">Número Factura</label>
            <input
                class="form-control @error('number') is-invalid @enderror"
                id="invoice-number"
                wire:model.defer="number"
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
                wire:model.defer="date"
                type="date"
            >
            @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-2">
            <label for="invoice-amount">Monto Factura</label>
            <input
                class="form-control @error('amount') is-invalid @enderror"
                id="invoice-amount"
                wire:model.defer="amount"
                type="text"
            >
            @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-sm-5">
            <label for="invoice-{{ $iteration }}">Archivo Factura</label>
            <input
                class="form-control form-control-file @error('file') is-invalid @enderror"
                type="file"
                wire:model.defer="file"
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
