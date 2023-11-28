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
                    <th>Tipo</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Fecha Recepción</th>
                    <th>Aprobaciones</th>
                    <th>Número</th>
                    <th width="100"></th>
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
                        <td>
                            {{ $reception->purchase_order }}
                        </td>
                        <td>
                            {{ $reception->purchaseOrder->json->Listado[0]->Proveedor->Nombre }}
                        </td>
                        <td>
                            {{ $reception->receptionType?->name }}
                        </td>
                        <td class="text-center">
                            {{ $reception->items->count() }} 
                        </td>
                        <td class="text-end">
                            $ {{ money($reception->total) }}
                        </td>
                        <td class="text-center">
                            {{ $reception->date?->format('Y-m-d') }}
                        </td>
                        <td>
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
                        </td>
                        <td>
                            @if ($reception->numeration and $reception->numeration->number)
                                {{ $reception->numeration->number }}
                            @else
                                [ Numerar ]
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('finance.receptions.show', $reception->id) }}"
                                class="btn btn-danger"
                                target="_blank">
                                <i class="bi bi-file-pdf-fill"></i>
                            </a>
                            <a href="#"
                                class="btn btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6"
                            class="text-center">No Hay Actas de Recepcion</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $receptions->links() }}
    </div>
</div>
