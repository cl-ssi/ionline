<div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('finance.dtes.index') }}">Ver dtes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('finance.dtes.upload') }}">Cargar archivo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('finance.payments.review') }}">Bandeja de Revisión de Pago</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('finance.payments.ready') }}">Bandeja de Pendientes para Pago</a>
        </li>
    </ul>


    <div class="row mb-3">
        <div class="col-8">
            <h3 class="mb-3">Listado de dtes cargadas en sistema</h3>
        </div>
        <div class="col">
            <button class="btn btn-success" type="button" wire:click="loadManualDTE">
                <i class="fas fa-plus"></i> Agregar una DTE Manualmente</button>
        </div>
    </div>





    @if ($showManualDTE)
        <div>
            @livewire('finance.manual-dtes')
        </div>
    @endif

    <div class="form-row mb-3">
        <div class="col-md-2">
            <input type="text" class="form-control" wire:model.defer="filter.folio" placeholder="folio">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" wire:model.defer="filter.folio_oc" placeholder="oc">
        </div>
        <div class="col-md-2">
            <select class="form-control" wire:model.defer="filter.folio_sigfe">
                <option value="sin_folio">Sin Folio SIGFE</option>
                <option value="con_folio">Con Folio SIGFE</option>
                <option value="todos">Todos</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control" wire:model.defer="filter.sender_status">
                <option value="Todas">Todas</option>
                <option value="No Confirmadas">No Confirmadas</option>
                <option value="Confirmadas">Confirmadas</option>
                <option value="Rechazadas">Rechazadas</option>
                <option value="Sin Envío">Sin Envío</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control" wire:model.defer="filter.selected_establishment">
                <option value="">Todos los Establecimientos</option>
                @foreach ($establishments as $establishment)
                    <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button class="btn btn-outline-secondary" type="button" wire:click="refresh">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>


    <div class="mb-3">
        <div class="d-flex align-items-center">
            <div class="color-box rounded-circle mr-2" style="background-color: #28a745;"></div>
            <i class="fas fa-circle text-success"></i>
            <span class="ml-2">Menos de 5 días</span>
        </div>
        <div class="d-flex align-items-center">
            <div class="color-box rounded-circle mr-2" style="background-color: #6c757d;"></div>
            <i class="fas fa-circle text-secondary"></i>
            <span class="ml-2">5 días</span>
        </div>
        <div class="d-flex align-items-center">
            <div class="color-box rounded-circle mr-2" style="background-color: #ffc107;"></div>
            <i class="fas fa-circle text-warning"></i>
            <span class="ml-2">Menos de 8 días</span>
        </div>
        <div class="d-flex align-items-center">
            <div class="color-box rounded-circle mr-2" style="background-color: #dc3545;"></div>
            <i class="fas fa-circle text-danger"></i>
            <span class="ml-2">8 días o más</span>
        </div>
    </div>


    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Bod</th>
                <th width="190">Admin C.</th>
                <th>Fecha Aceptación SII (días)</th>
                <th width="100px">Estab</th>
                <th></th>
                <th>Cenabast</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
                @php
                    $daysDifference = $dte->fecha_recepcion_sii ? $dte->fecha_recepcion_sii->diffInDays(now()) : null;
                    $rowClass = '';
                    if ($daysDifference !== null) {
                        if ($daysDifference < 5) {
                            $rowClass = 'table-success';
                        } elseif ($daysDifference === 5) {
                            $rowClass = 'table-secondary';
                        } elseif ($daysDifference < 8) {
                            $rowClass = 'table-warning';
                        } else {
                            $rowClass = 'table-danger';
                        }
                    }
                @endphp

                <tr class="{{ $rowClass }}">
                    <td class="small">{{ $dte->id }}</td>
                    <td class="small">
                        @if ($dte->tipo_documento != 'boleta_honorarios')
                            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}"
                                target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @else
                            <a href="{{ $dte->uri }}" target="_blank"
                                class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @endif
                        <br>
                        {{ $dte->tipo_documento }}
                        <br>
                        {{ $dte->emisor }}
                    </td>
                    <td class="small">
                        @livewire('finance.get-purchase-order', ['dte' => $dte], key($dte->id))
                    </td>
                    <td class="small">
                        @if ($dte->requestForm)
                            <a href="{{ route('request_forms.show', $dte->requestForm->id) }}" target="_blank">
                                {{ $dte->requestForm->folio }}
                            </a>
                            <br>
                            @if ($dte->requestForm->signatures_file_id)
                                <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado"
                                    href="{{ $dte->requestForm->signatures_file_id == 11
                                        ? route('request_forms.show_file', $dte->requestForm->requestFormFiles->first() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$dte->requestForm, 1]) }}"
                                    target="_blank" title="Certificado">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif

                            @if ($dte->requestForm->old_signatures_file_id)
                                <a class="btn btn-secondary btn-sm"
                                    title="Ver Formulario de Requerimiento Anterior firmado"
                                    href="{{ $dte->requestForm->old_signatures_file_id == 11
                                        ? route('request_forms.show_file', $dte->requestForm->requestFormFiles->first() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$dte->requestForm, 0]) }}"
                                    target="_blank" title="Certificado">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif

                            @if ($dte->requestForm->signedOldRequestForms->isNotEmpty())
                                <a class="btn btn-secondary btn-sm"
                                    title="Ver Formulario de Requerimiento Anteriores firmados"
                                    href="{{ $dte->requestForm->old_signatures_file_id == 11
                                        ? route('request_forms.show_file', $dte->requestForm->requestFormFiles->first() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$dte->requestForm, 0]) }}"
                                    target="_blank" data-toggle="modal"
                                    data-target="#history-fr-{{ $dte->requestForm->id }}">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif
                        @endif
                    </td>
                    <td class="small">
                        @foreach ($dte->controls as $control)
                            <a class="btn btn-sm btn-outline-primary"
                                href="{{ route('warehouse.control.show', $control) }}" target="_blank">
                                #{{ $control->id }}
                            </a>
                        @endforeach
                    </td>
                    <td class="small">
                        @if ($dte->requestForm)
                            @if ($dte->requestForm->contractManager)
                                {{ $dte->requestForm->contractManager->shortName }} <br>
                                @livewire('finance.dte-send-confirmation', ['dte' => $dte->id, 'user' => $dte->requestForm->contractManager->id], key($dte->id))
                            @endif
                        @endif
                    </td>
                    <td class="small">
                        {{ $dte->fecha_recepcion_sii ?? '' }} <br>
                        ({{ $dte->fecha_recepcion_sii ? $dte->fecha_recepcion_sii->diffInDays(now()) : '' }} días)
                    </td>

                    <td>
                        @if ($dte->establishment)
                            {{ $dte->establishment->name }}
                        @else
                            @livewire('finance.assign-establishment', ['dteId' => $dte->id, 'establishments'=>$establishments], key($dte->id))
                        @endif
                    </td>

                    <td>
                        <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                            data-target="#collapse{{ $dte->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $dte->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="collapse width" id="collapse{{ $dte->id }}">
                            <pre>
                            {{ print_r($dte->toArray()) }}
                        </pre>
                        </div>
                    </td>

                    <td class="center text-center">
                        @livewire('finance.assign-cenabast', ['dteId' => $dte->id], key($dte->id))
                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $dtes->links() }}

</div>
