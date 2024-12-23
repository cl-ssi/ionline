<div>

    @include('finance.payments.partials.nav')

    <h3>Dtes cargadas en sistema</h3>

    <div class="row g-2 mb-3">
        <div class="col-md-1">
            <label for="for-establishment" class="form-label">Estab.</label>
            <select class="form-select" wire:model="filter.establishment">
                <option value="">Todos</option>
                @foreach ($establishments as $name => $id)
                    <option value="{{ $name }}">{{ $id }}</option>
                @endforeach
                <option value="?">Sin</option>
            </select>
        </div>
        <div class="col-md-1">
            <label for="for-id" class="form-label">ID</label>
            <input type="text" class="form-control" wire:model="filter.id" placeholder="id" autocomplete="off">
        </div>
        <div class="col-md-1">
            <label for="for-emisor" class="form-label">Rut</label>
            <input type="text" class="form-control" wire:model="filter.emisor" placeholder="emisor">
        </div>
        <div class="col-md-1">
            <label for="for-folio" class="form-label">Folio</label>
            <input type="text" class="form-control" wire:model="filter.folio" placeholder="folio">
        </div>
        <div class="col-md-2">
            <label for="for-folio_oc" class="form-label">Folio OC</label>
            <input type="text" class="form-control" wire:model="filter.folio_oc" placeholder="folio oc">
        </div>
        <div class="col-md-1">
            <label for="for-oc" class="form-label">OC</label>
            <select class="form-select" wire:model="filter.oc">
                <option value="Todos">Todas</option>
                <option value="Sin OC">Sin</option>
                <option value="Con OC">Con</option>
                <option value="Sin OC de MP">Sin OC de MP</option>
            </select>
        </div>
        <div class="col-md-1">
            <label for="for-reception" class="form-label">Recepción</label>
            <select class="form-select" wire:model="filter.reception">
                <option value="Todos">Todas</option>
                <option value="Sin Recepción">Sin</option>
                <option value="Con Recepción">Con</option>
            </select>
        </div>
        <div class="col-md-1">
            <label for="for-folio_sigfe" class="form-label">Folio Sigfe</label>
            <select class="form-select" wire:model="filter.folio_sigfe">
                <option value="Todos">Todos</option>
                <option value="Sin SIGFE">Sin</option>
                <option value="Con SIGFE">Con</option>
            </select>
        </div>
        <div class="col-md-1">
            <label for="for-tipo_documento" class="form-label">Tipo DTE</label>
            <select class="form-select" wire:model="filter.tipo_documento">
                <option value="">Todas</option>
                <option value="facturas">Facturas (Afecta y Exenta)</option>
                <option value="factura_electronica">FE: Factura Electrónica</option>
                <option value="factura_exenta">FE: Factura Exenta</option>
                <option value="guias_despacho">GD: Guias Despacho</option>
                <option value="nota_credito">NC: Nota Crédito</option>
                <option value="nota_debito">ND: Nota Débito</option>
                <option value="boleta_honorarios">BH: Boleta Honorarios</option>
                <option value="boleta_electronica">BE: Boleta Electrónica</option>
            </select>
        </div>
        <div class="col-md-1">
            <label for="search" class="form-label">&nbsp;</label>
            <button class="btn btn-primary form-control" type="button" wire:click="refresh">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <div class="col-md-1">
            <label for="search" class="form-label">&nbsp;</label>
            <button class="btn btn-outline-success form-control" type="button" wire:click="exportToExcel">
                <i class="fas fa-file-excel"></i>
            </button>
        </div>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-md-2">
            <label for="for-fecha_desde" class="form-label">Fecha Desde SII</label>
            <input type="date" class="form-control" wire:model="filter.fecha_desde_sii">
        </div>

        <div class="col-md-2">
            <label for="for-fecha_hasta" class="form-label">Fecha Hasta SII</label>
            <input type="date" class="form-control" wire:model="filter.fecha_hasta_sii">
        </div>

        <div class="col-md-2">
            <label for="for-tipo_documento" class="form-label">Estado</label>
            <select class="form-select" wire:model="filter.estado">
                <option value="">Todas</option>
                <option value="sin_estado">Sin Estado</option>
                <option value="revision">Revision</option>
                <option value="listo_para_pago">Listo para Pago</option>
                <option value="pagado">Pagado</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="for-tipo_documento" class="form-label">Subtitulo</label>
            <select class="form-select" wire:model="filter.subtitulo">
                <option value="">Todas</option>
                @foreach ($subtitles as $subtitle)
                <option value="{{$subtitle->id}}">{{$subtitle->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="for-fecha_desde" class="form-label">Fecha Desde Revisión</label>
            <input type="date" class="form-control" wire:model="filter.fecha_desde_revision">
        </div>

        <div class="col-md-2">
            <label for="for-fecha_hasta" class="form-label">Fecha Hasta Revisión</label>
            <input type="date" class="form-control" wire:model="filter.fecha_hasta_revision">
        </div>

    </div>


    <table class="table table-sm table-bordered" wire:loading.class="text-muted">
        <thead>
            <tr>
                <th>ID</th>
                <th width="55px">Estb.</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Recepción/Adjuntos</th>
                <th width="90">Fecha Aceptación SII (días)</th>
                <!-- <th>Devengo</th> -->
                <th>Enviado a Bandeja de Revisión por</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
                <tr class="{{ $dte->rowClass }}">
                    <td class="text-center">
                        {{ $dte->id }}
                        <br>
                        @cannot('Payments: viewer')
                            <input class="form-check-input" style="scale: 1.5;" type="checkbox"
                                id="ids.{{ $dte->id }}" wire:model="ids.{{ $dte->id }}">
                        @endcannot
                    </td>
                    <td>
                        {{ $dte->establishment?->alias }}
                    </td>
                    <td class="small">
                        @include('finance.payments.partials.dte-info')
                    </td>
                    <td class="small">
                        @livewire('finance.get-purchase-order', ['dte' => $dte], key($dte->id))
                    </td>
                    <td class="small">
                        @include('finance.payments.partials.fr-info')

                        {{ $dte->requestForm?->contractManager?->tinyName }} 
                        {{ $dte->contractManager?->tinyName }}
                        <br>
                        
                        <!-- Si tiene administrador de contrato mostrar el avion para enviar notificación -->
                        @if($dte->requestForm?->contractManager?->id OR $dte->contract_manager_id)
                            @if($dte->confirmation_send_at AND $dte->receptions->isEmpty())
                                <i class="fas fa-paper-plane"></i> 
                                {{ $dte->confirmation_send_at }}
                            @else
                                <button type="button" 
                                    class="btn btn-sm btn-primary" 
                                    wire:click="sendConfirmation({{ $dte->id }})">
                                    <i class="fas fa-fw fa-paper-plane"></i>
                                </button>
                            @endif
                        @endif

                        {{ $dte->estado_reclamo }}
                    </td>
                    <td class="small">
                         <!-- Nuevo módulo de Recepciones -->
                        @include('finance.payments.partials.receptions-info')
                    </td>

                    <td class="small">
                        {{ $dte->fecha_recepcion_sii ?? '' }} <br>
                        ({{ $dte->fecha_recepcion_sii ? (int) $dte->fecha_recepcion_sii->diffInDays(now()) : '' }} días)
                    </td>
                    <td class="small">
                        {{$dte->allReceptionsUser?->shortName}}<br>
                        {{$dte->allReceptionsOU?->name}}<br>
                        {{$dte->all_receptions_at}}
                        <!-- {{ $dte->estado_devengo }}<br>
                        {{ $dte->folio_sigfe }} -->
                    </td>

                    <td class="small">
                        @cannot('Payments: viewer')
                            <button class="btn btn-sm btn-primary" wire:click="show({{ $dte->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                        @endcannot
                    </td>

                </tr>

                @if ($showEdit == $dte->id)
                    <tr>
                        <td colspan="11">

                            <div class="row g-2">
                                <div class="form-group col-md-2">
                                    <label for="for_folio_oc">Folio OC</label>
                                    <input type="text" class="form-control" id="for_folio_oc"
                                        wire:model="folio_oc">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="for_monto_total">Monto Total</label>
                                    <input type="text" class="form-control" id="for_folio_oc"
                                        wire:model="monto_total" disabled>
                                </div>

                                @switch($dte->tipo_documento)
                                    @case('guias_despacho')
                                    @case('nota_credito')
                                    @case('nota_debito')
                                        <!-- TODO: Si es guia, se puede asociar a multiple
                                            si es nota de crédito o débito se debería poder asociar sólo a una
                                            preguntar a gina o juan toro -->
                                        <div class="form-group col-md-4">
                                            <label for="for_asociate">Asociar a Factura - ID DTE:</label>
                                            <select multiple class="form-control" id="for_asociate"
                                                wire:model="asociate_invoices">
                                                @foreach ($facturasEmisor as $factura)
                                                    <option value="{{ $factura->id }}">
                                                        {{ $factura->folio }} ( $ {{ money($factura->monto_total) }} ) - ID
                                                        DTE: {{ $factura->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @break

                                    @case('factura_electronica')
                                    @case('factura_exenta')
                                    @case('boleta_honorarios')
                                    @case('boleta_electronica')
                                        @if ( !$dte->requestForm )
                                            <div class="form-group col-md-3">
                                                <label for="for-contract_manager">Administrador de contrato</label>
                                                @livewire('search-select-user', [
                                                    'emit_name' => 'setContractManager',
                                                    'user' => $dte->contractManager,
                                                ], key('contract_manager'.$dte->id))
                                            </div>
                                        @endif
                                    @break
                                @endswitch



                                <div class="form-group col-md-3">
                                    <label for="for_asociate">Operaciones:</label>
                                    <br>
                                    <button type="submit" class="btn btn-primary"
                                        wire:click="save({{ $dte->id }})">Guardar </button>
                                    <button type="button" class="btn btn-outline-secondary"
                                        wire:click="dismiss">Cancelar </button>
                                </div>

                            </div>

                            <hr>

                            @switch($dte->tipo_documento)
                                @case('factura_electronica')
                                @case('factura_exenta')
                                @case('boleta_honorarios')
                                @case('boleta_electronica')
                                    <div class="row">
                                        <div class="col-10">
                                            @if($dte->purchaseOrder)
                                                @foreach($dte->purchaseOrder->receptions as $reception)
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                            type="checkbox" 
                                                            id="defaultCheck{{ $reception->id }}"
                                                            @if($dte->id == $reception->dte_id)
                                                                wire:click="updateReceptionDteId({{ $reception->id }}, null)"
                                                                checked
                                                            @else
                                                                wire:click="updateReceptionDteId({{ $reception->id }}, {{ $dte->id }})"
                                                            @endif
                                                            @disabled($reception->dte_id AND $reception->dte_id != $dte->id)
                                                        >
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            @if($reception->dte_id AND $reception->dte_id != $dte->id)
                                                                DTE: {{ $reception->dte_id }}
                                                            @endif
                                                
                                                            @if($reception->signedFileLegacy)
                                                                <a class="link-primary" href="{{ route('file.download', $reception->signedFileLegacy) }}" target="_blank">
                                                                    id: {{ $reception->id }} Acta firmada (ex módulo Cenabast)
                                                                </a>
                                                            @else
                                                                <a href="{{ route('finance.receptions.show', $reception->id) }}" target="_blank">
                                                                    <b>Nº:</b> {{ $reception->numeration->number ?? 'Pendiente' }} 
                                                                    <b>Fecha:</b> {{ $reception->date?->format('Y-m-d') }}
                                                                </a>
                                                                @if($reception->numeration?->number)
                                                                    <a class="text-link" target="_blank"
                                                                        href="{{ route('documents.partes.numeration.show_numerated', $reception->numeration) }}">
                                                                        [ Ver ]
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </label>
                                                        <br>

                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-success form-control" 
                                                wire:click="updateAllReceptionsStatus({{ $dte->id }})"
                                                wire:loading.attr="disabled">
                                                <i class="bi bi-currency-dollar"></i>
                                                A revisión
                                            </button>
                                        </div>
                                    </div>
                                    @break
                                @case('guias_despacho')
                                @case('nota_credito')
                                @case('nota_debito')
                                    @break
                            @endswitch

                            <hr>

                            <h6>Rechazo</h6>
                            <ul>
                                @if($dte->purchaseOrder)
                                    @foreach($dte->purchaseOrder->rejections as $rejection)
                                        <li>
                                            <b>Acta ID:</b> {{ $rejection->id }}
                                            <b>Creador:</b> {{ $rejection->creator->shortName }}<br>
                                            <span class="text-danger"> 
                                                <b>Motivo:</b>
                                                {{ $rejection->rejected_notes }}
                                            </span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <div class="row">

                                <div class="col-10">
                                    <label for="">Motivo de rechazo DTE contabilidad</label>
                                    <input type="text" 
                                        class="form-control" 
                                        wire:model="reason_rejection">
                                </div>
                                <div class="col-2">
                                    <label for="">&nbsp;</label>
                                    <button class="btn btn-danger form-control" 
                                        wire:click="rejectDte({{ $dte->id }})">
                                        Rechazar
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div wire:loading.remove>
        {{ $dtes->links() }}
    </div>

    <div class="row">
        @cannot('Payments: viewer')
            <div class="col">
                <div class="row">
                    <div class="col-3">
                        <select class="form-select" wire:model="establishment_id">
                            <option value=""></option>
                            @foreach ($establishments as $name => $id)
                                <option value="{{ $name }}">{{ $id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" wire:click="setEstablishment">
                            Asignar establecimiento
                        </button>
                    </div>
                </div>
            </div>
        @endcannot

        <div class="col-3">
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-circle text-success"></i>
                    <span class="ml-2">Menos de 5 días</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-circle text-info"></i>
                    <span class="ml-2">5 días</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-circle text-warning"></i>
                    <span class="ml-2">Menos de 8 días</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-circle text-danger"></i>
                    <span class="ml-2">8 días o más</span>
                </div>
            </div>
        </div>

    </div>

</div>
