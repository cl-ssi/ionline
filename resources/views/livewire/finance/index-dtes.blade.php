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


    <h3 class="mb-3">Listado de dtes cargadas en sistema</h3>

    <div class="row mb-3">
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
                <option value="no confirmadas y enviadas a confirmación">no confirmadas y enviadas a confirmación
                </option>
                <option value="Enviado a confirmación">Enviado a confirmación</option>
                <option value="Confirmada">Confirmada</option>
                <option value="No Confirmada">No Confirmada</option>
                <option value="Todas">Todas</option>
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
            <button class="btn btn-outline-secondary" type="button" wire:click="refresh"> <i class="fas fa-search"></i>
                Buscar</button>
        </div>



        <div class="col-md-2 text-right">
            <button class="btn btn-success" type="button" wire:click="loadManualDTE">
                <i class="fas fa-plus"></i> Agregar una DTE Manualmente</button>
        </div>

    </div>



    @if ($showManualDTE)
        <div>
            @livewire('finance.manual-dtes')
        </div>
    @endif

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID Interno</th>
                <th>Tipo documento</th>
                <th>Folio</th>
                <th>Emisor</th>
                <th>Folio OC</th>
                <th>FR</th>
                <th>Bod</th>
                <th>Admin C.</th>
                <th>Detalle</th>
                <th>Fecha Aceptación SII (días)</th>
                <th>Establecimiento</th>
                <th>Guardar</th>
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
                        } elseif ($daysDifference < 8) {
                            $rowClass = 'table-warning';
                        } else {
                            $rowClass = 'table-danger';
                        }
                    }
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $dte->id }}</td>
                    <td>{{ $dte->tipo_documento }}</td>
                    <td>
                        @if ($dte->tipo_documento != 'boleta_honorarios')
                            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}"
                                target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @else
                            <a href="{{ $dte->uri }}" target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @endif
                    </td>
                    <td>{{ $dte->emisor }}</td>
                    <td>{{ $dte->folio_oc }}</td>
                    <td>
                        @if ($dte->immediatePurchase)
                            @if ($dte->requestForm)
                                <a class="btn btn-primary btn-block"
                                    href="{{ route('request_forms.show', $dte->requestForm->id) }}" target="_blank">
                                    <i class="fas fa-file-alt"></i> {{ $dte->requestForm->folio }}
                                </a>
                            @endif
                        @endif
                    </td>
                    <td>
                        @foreach ($dte->controls as $control)
                            {{ $control->id }}
                        @endforeach
                    </td>
                    <td>
                        @if ($dte->immediatePurchase)
                            @if ($dte->requestForm)
                                @if ($dte->requestForm->contractManager)
                                    {{ $dte->requestForm->contractManager->shortName }}
                                    @livewire('finance.dte-send-confirmation', ['dte' => $dte->id, 'user' => $dte->requestForm->contractManager->id], key($dte->id))
                                @endif
                            @endif
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                            data-target="#collapse{{ $dte->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $dte->id }}">
                            Ver detalle
                        </button>
                        <div class="collapse width" id="collapse{{ $dte->id }}">
                            <pre>
                            {{ print_r($dte->toArray()) }}
                        </pre>
                        </div>
                    </td>
                    <td>
                        {{ $dte->fecha_recepcion_sii ?? '' }}
                        ({{ $dte->fecha_recepcion_sii ? $dte->fecha_recepcion_sii->diffInDays(now()) : '' }} días)
                    </td>
                    <td>
                        <div>                        
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>



                        <select class="form-control" wire:change="updateSelectedEstablishment({{ $dte->id }}, $event.target.value)">
                            <option value="">Seleccionar Establecimiento</option>
                            @foreach ($establishments as $establishment)
                                <option value="{{ $establishment->id }}"
                                    @if ($dte->establishment_id == $establishment->id) selected @endif>
                                    {{ $establishment->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-primary"
                            wire:click="saveEstablishment({{ $dte->id }})">Guardar</button>                        
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

    {{ $dtes->links() }}

</div>
