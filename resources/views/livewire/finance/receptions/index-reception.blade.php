<div>
    <h3 class="mb-3">Acta de Recepción en Sistema</h3>

    <!-- MENU -->
    @include('finance.receptions.partials.nav')

    <div class="row g-2 d-print-none mb-3">
        <fieldset class="form-group col-md-1">
            <label for="number">ID</label>
            <input wire:model.defer="filter_id"
                id="filter_id"
                class="form-control"
                autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="oc">OC</label>
            <input wire:model.defer="filter_purchase_order"
                id="filter_purchase_order"
                class="form-control"
                autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="receptionType">Tipo</label>
            <select class="form-select"
                wire:model="filter_reception_type_id">
                <option value=""></option>
                @foreach ($types as $id => $type)
                    <option value="{{ $id }}">{{ $type }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="number">Fecha Recepción</label>
            <input wire:model.defer="filter_date"
                id="date"
                class="form-control"
                type="date">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="number">Número</label>
            <input wire:model.defer="filter_number"
                id="filter_number"
                class="form-control"
                autocomplete="off">
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
                            {{ $reception->purchase_order }}
                        </td>
                        <td>
                            @if($reception->purchaseOrder)
                                {{ $reception->purchaseOrder?->json->Listado[0]->Proveedor->Nombre }}
                                @else
                                {{ $reception->dte->razon_social_emisor }}
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
                                    <i class="bi bi-file-pdf-fill">soy sin OC</i>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($reception->rejected)
                                <span class="badge bg-danger">Rechazada</span>
                            @else
                                @foreach ($reception->approvals as $approval)
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
                                        title="Fecha: ">
                                        <small>
                                            @if ($approval->approver)
                                                {{ $approval->approver->initials }}
                                            @elseif($approval->sentToOu)
                                                {{ $approval->sentToOu->currentManager?->user->initials }}
                                            @elseif($approval->sentToUser)
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
                        </td>
                        <td>
                            @if($reception->supportFile)
                                <a href="{{ route('file.download', $reception->supportFile) }}"
                                    target="_blank">
                                    <i class="fas fa-paperclip"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            @if($reception->rejected == false)
                                <a href="{{ route('finance.receptions.create', $reception) }}"
                                    class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
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
