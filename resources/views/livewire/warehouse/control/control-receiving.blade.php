<div>
    @include('layouts.partials.flash_message')

    <div class="row">
        <div class="col my-2">
            <h5>
                Listado de
                Ingresos:
                {{ $store->name }}
            </h5>
        </div>

        <div class="col text-right">
            @if($store)
                @can('Store: create reception by donation')
                    <a
                        class="btn btn-sm btn-outline-primary"
                        href="{{ route('warehouse.controls.create', [
                            'store' => $store,
                            'type' => 'receiving',
                            'nav' => $nav,
                        ]) }}"
                    >
                        <i class="fas fa-download"></i> Ingreso Sin Orden de Compra
                    </a>
                @endcan
                @can('Store: create reception by purcharse order')
                    <a
                        class="btn btn-sm btn-primary"
                        href="{{ route('warehouse.generate-reception', [
                            'store' => $store,
                            'nav' => $nav,
                        ]) }}"
                    >
                        <i class="fas fa-shopping-cart"></i> Ingreso Con Orden de Compra
                    </a>
                @endcan
            @endif
        </div>
    </div>

    <div class="table table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Fecha</th>
                    <th>Origen</th>
                    <th>Programa</th>
                    <th class="text-center"># Productos</th>
                    <!-- <th class="text-center">Estado</th> -->
                    <th class="text-center">Ingreso Bodega</th>
                    <th>Facturas</th>
                    <th>Enviado Firma</th>
                    <th>Firmado</th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="9">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($controls as $control)
                <tr>
                    <td class="text-center" nowrap>
                        <a
                            @if($control->isClose())
                                href="{{ route('warehouse.control.add-product', [
                                    'store' => $store,
                                    'control' => $control,
                                    'type' => $control->isReceiving() ? 'receiving' : 'dispatch',
                                    'nav' => $nav,
                                ]) }}"
                            @else
                                href="{{ route('warehouse.controls.edit', [
                                    'store' => $store,
                                    'control' => $control,
                                    'type' => $control->isReceiving() ? 'receiving' : 'dispatch',
                                    'nav' => $nav,
                                ]) }}"
                            @endif
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-edit"></i> {{ $control->id }}
                        </a>
                    </td>
                    <td nowrap>{{ $control->date_format }}</td>
                    <td>
                        @switch($control->type_reception_id)
                            @case(\App\Models\Warehouse\TypeReception::receiving())
                                {{ optional($control->origin)->name }}
                                @break
                            @case(\App\Models\Warehouse\TypeReception::receiveFromStore())
                                {{ optional($control->originStore)->name }}
                                @break
                            @case(\App\Models\Warehouse\TypeReception::return())
                                {{ optional($control->originStore)->name }}
                                @break
                            @case(\App\Models\Warehouse\TypeReception::purchaseOrder())
                                {{ $control->po_code }}
                                @break
                            @case(\App\Models\Warehouse\TypeReception::adjustInventory())
                                {{ optional($control->typeReception)->name }}
                                @break
                        @endswitch
                        <br>
                        <small>
                            {{ optional($control->typeReception)->name }}
                        </small>
                    </td>
                    <td>{{ $control->program_name }}</td>
                    <td class="text-center">{{ $control->items->count() }}</td>
                    <!-- <td class="text-center">
                        <span class="badge badge-{{ $control->color_confirm }}">
                            {{ $control->confirm_format }}
                        </span>
                    </td> -->
                    <td class="text-center">
                        @if($control->isConfirmed())
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
                        @foreach($control->invoices as $invoice)
                            <a
                                href="{{ $invoice->link }}"
                                class="btn btn-sm btn-success"
                                target="_blank"
                                title="Ver Factura {{ $invoice->number }}"
                            >
                                <span class="fas fa-file-invoice-dollar" aria-hidden="true">
                                </span>
                            </a>
                        @endforeach
                    </td>
                    <td class="text-center font-weight-bold text-success">
                        {{ $control->completed_invoices ? '✓' : ''}}
                    </td>
                    <td class="text-center">
                        @if($control->technicalSignature && $control->technicalSignature->signaturesFlows->first()->isSigned())
                            <a
                                href="{{ route('documents.signatures.showPdf', [
                                    $control->technicalSignature->signaturesFlows->first()->signaturesFile->id, time()
                                ]) }}"
                                class="btn btn-sm btn-danger" target="_blank"
                                title="Ver documento"
                            >
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="9">
                            <em>No hay resultados</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <caption>
                Total de resultados: {{ $controls->total() }}
            </caption>
        </table>
    </div>

    {{ $controls->links() }}
</div>
