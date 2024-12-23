<div>
    <h3 class="mb-3">Acta de Recepción en Sistema</h3>

    <!-- MENU -->
    @include('finance.receptions.partials.nav')

    <div class="row g-2 d-print-none mb-3">
        <fieldset class="form-group col-md-1">
            <label for="number">ID</label>
            <input wire:model="filter_id"
                id="filter_id"
                class="form-control"
                autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="oc">OC</label>
            <input wire:model="filter_purchase_order"
                id="filter_purchase_order"
                class="form-control"
                autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="receptionType">Tipo</label>
            <select class="form-select"
                wire:model.live="filter_reception_type_id">
                <option value=""></option>
                @foreach ($types as $id => $type)
                    <option value="{{ $id }}">{{ $type }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="number">Fecha Recepción</label>
            <input wire:model="filter_date"
                id="date"
                class="form-control"
                type="date">
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="number">Número</label>
            <input wire:model="filter_number"
                id="filter_number"
                class="form-control"
                autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="responsable">Responsable</label>
            <input wire:model="filter_responsable"
                id="filter_responsable"
                class="form-control"
                autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="for-pending">Estado</label>
            <select class="form-select"
                wire:model="filter_pending">
                <option value="all">Todas</option>
                <option value="pending">Pendiente Aprobación</option>
                <option value="without_number">Sin Numerar</option>
                <option value="with_number">Numeradas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="">&nbsp;</label>
            <button class="btn btn-primary form-control"
                type="button"
                wire:click="getReceptions">
                <i class="bi bi-filter"></i>
            </button>
        </fieldset>

    </div>


    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>OC</th>
                    <th>Proveedor</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Responsable</th>
                    <th>Fecha Recepción</th>
                    @canany(['be god', 'Receptions: upload to mercado público'])
                    <th>Mercado Público</th>
                    @endcanany
                    <th>Orig.</th>
                    <th>Aprobaciones</th>
                    <th>Número</th>
                    <th>Adjuntos</th>
                    <th width="55"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none">
                    <td class="text-center"
                        colspan="7">
                        @include('layouts.bt5.partials.spinner')
                    </td>
                </tr>
                @forelse($receptions as $reception)
                    <tr>
                        <td class="text-center"
                            nowrap>
                            {{ $reception->id }}
                        </td>
                        <td nowrap>
                            @if($reception->purchaseOrder)
                                <a target="_blank"
                                    href="{{ route('finance.purchase-orders.show', $reception->purchaseOrder) }}">
                                    {{ $reception->purchase_order }}
                                </a>
                            @else
                                {{ $reception->purchase_order }}
                            @endif
                        </td>
                        <td>
                            @if($reception->purchaseOrder)
                                {{ $reception->purchaseOrder?->json->Listado[0]->Proveedor->Nombre }}
                            @else
                                {{ $reception->dte?->razon_social_emisor }}
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $reception->items->count() }} 
                        </td>
                        <td class="text-end" nowrap>
                            $ {{ money($reception->total) }}
                        </td>
                        <td>
                            {{ $reception->responsable?->shortName }}
                        </td>
                        <td class="text-center">
                            {{ $reception->date?->format('Y-m-d') }}
                        </td>
                        @canany(['be god', 'Receptions: upload to mercado público'])
                        <td class="text-center">
                            <input type="checkbox" {{ $reception->mercado_publico ? "checked" : "" }} wire:click="toggleMercadoPublico({{ $reception->id }})"  >
                        </td>
                        @endcanany
                        <td>
                            @if($reception->rejected == false)
                                @if($reception->purchase_order)
                                    @if($reception->signedFileLegacy)
                                        <a href="{{ route('file.download', $reception->signedFileLegacy) }}"
                                            class="btn btn-outline-secondary"
                                            target="_blank">
                                            <i class="bi bi-file-pdf-fill"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('finance.receptions.show', $reception->id) }}"
                                            class="btn btn-outline-success"
                                            target="_blank">
                                            <i class="bi bi-file-pdf-fill"></i>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('finance.receptions.show', $reception->id) }}"
                                        class="btn btn-outline-info"
                                        target="_blank">
                                        <i class="bi bi-file-pdf-fill"></i>
                                    </a>
                                @endif
                            @endif
                        </td>
                        <td nowrap>
                            @if($reception->rejected)
                                <span class="badge bg-danger">Rechazada</span>
                            @else
                                @foreach ($reception->approvals as $approval)
                                    {{-- <img src="{{ $approval->avatar }}" alt=""> --}}
                                    <span style="width=50px;"
                                        @class([
                                            'd-inline-bloc',
                                            'img-thumbnail',
                                            'rounded-circle',
                                            'bg-success' => $approval->status,
                                            'text-white' => $approval->status,
                                            'border-dark',
                                        ])
                                        tabindex="0"
                                        data-toggle="tooltip"
                                        >
                                        <small title="
                                            @if ($approval->approver)
                                                {{ $approval->approver->shortName }}">
                                                {{ $approval->approver->initials }}
                                            @elseif($approval->sentToOu)
                                                {{ $approval->sentToOu->currentManager?->user->shortName }}">
                                                {{ $approval->sentToOu->currentManager?->user->initials }}
                                            @elseif($approval->sentToUser)
                                                {{ $approval->sentToUser->shortName }}">
                                                {{ $approval->sentToUser->initials }}
                                            @endif
                                        </small>
                                    </span> &nbsp;
                                @endforeach
                            @endif
                        </td>
                        <td nowrap>
                            @if($reception->rejected == false)
                                @if ($reception->numeration and $reception->numeration->number)
                                    <a class="btn btn-outline-danger" href="{{ route('documents.partes.numeration.show_numerated', $reception->numeration) }}" target="_blank">
                                        <i class="bi bi-file-pdf"></i>  {{ $reception->numeration->number }}
                                    </a>
                                @endif
                            @endif

                                @if($reception->numeration and $reception->numeration->number == null )
                                <button class="btn btn-primary"  wire:loading.attr="disabled"
                                    wire:click="numerate( {{ $reception->numeration->id }} )">
                                    <i class="fa fa-spinner fa-spin" wire:loading></i>
                                    <i class="bi" wire:loading.class="d-none">Numerar</i> 
                                    @if($error_msg)
                                        <div class="alert alert-danger"
                                            role="alert">
                                            {{ $error_msg }}
                                        </div>
                                    @endif
                                </button>
                                @endif
                        </td>
                        <td>
                            {{-- Adjuntos --}}
                            @if($reception->dte)
                                <a target="_blank"
                                    @switch($reception->dte->tipo_documento)
                                        @case('factura_electronica')
                                        @case('factura_exenta')
                                        @case('guias_despacho')
                                        @case('nota_debito')
                                        @case('nota_credito')
                                            href="{{ $reception->dte->uri }}"
                                            @break
                                        @case('boleta_honorarios')
                                                href="{{ $reception->dte->uri }}"
                                            @break
                                        @case('boleta_electronica')
                                            href="{{ route('finance.dtes.downloadManualDteFile', $reception->dte) }}"
                                            @break
                                    @endswitch
                                    title="{{ $reception->dte->tipoDocumentoIniciales }} {{ $reception->dte->folio }}">
                                    <i class="bi bi-currency-dollar"></i>
                                </a>
                            @endif

                            @if($reception->supportFile)
                                <a href="{{ route('file.download', $reception->supportFile) }}"
                                    target="_blank">
                                    <i class="bi bi-paperclip"></i>
                                </a>
                            @endif

                            @if($reception->noOcFile)
                                 <a href="{{ route('file.download', $reception->noOcFile) }}"
                                    target="_blank">
                                    <i class="bi bi-file-pdf-fill"></i>
                                </a>
                            @endif
                        </td>

                        <td>
                            @if($reception->rejected == false)
                                @if(($reception->created_at->diffInDays(now()) < 365 && $reception->creator_id == auth()->id()) || (auth()->user()->can('Receptions: load file retroactive')))
                                    <a href="{{ route('finance.receptions.edit', $reception) }}"
                                        class="btn btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <br><br>
                                @endif
                            @endif

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="10"
                            class="text-center">No Hay Actas de Recepcion</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $receptions->links() }}
    </div>
</div>
