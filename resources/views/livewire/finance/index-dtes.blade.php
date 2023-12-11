<div>

    @include('finance.payments.partials.nav')

    <div class="row mb-3">
        <div class="col-6">
            <h3>Dtes cargadas en sistema</h3>
        </div>
        @cannot('Payments: viewer')
            <div class="col">
                <button class="btn btn-sm btn-success" type="button" wire:click="loadManualDTE">
                    <i class="fas fa-plus"></i> Cargar DTE individual</button>
            </div>
            <div class="col">
                <a class="btn btn-sm btn-success" href="{{ route('finance.dtes.upload') }}">
                    <i class="fas fa-plus"></i> Cargar DTEs desde archivo</a>
            </div>
        @endcannot
    </div>


    @if ($showManualDTE)
        <div>
            @livewire('finance.manual-dtes')
        </div>
    @endif


    <div class="row g-2 mb-3">
        <div class="col-md-2">
            <select class="form-select" wire:model.defer="filter.establishment">
                <option value="">Todos los Establecimientos</option>
                @foreach ($establishments as $name => $id)
                    <option value="{{ $name }}">{{ $id }}</option>
                @endforeach
                <option value="?">Sin establecimiento</option>
            </select>
        </div>
        <div class="col-md-1">
            <input type="text" class="form-control" wire:model.defer="filter.id" placeholder="id" autocomplete="off">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" wire:model.defer="filter.folio" placeholder="folio">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" wire:model.defer="filter.folio_oc" placeholder="oc">
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.defer="filter.folio_sigfe">
                <option value="Todos">Todos</option>
                <option value="Sin Folio SIGFE">Sin Folio SIGFE</option>
                <option value="Con Folio SIGFE">Con Folio SIGFE</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.defer="filter.tipo_documento">
                <option value="">Todas</option>
                <option value="factura_electronica">FE: Factura Electrónica</option>
                <option value="factura_exenta">FE: Factura Exenta</option>
                <option value="guias_despacho">GD: Guias Despacho</option>
                <option value="nota_credito">NC: Nota Crédito</option>
                <option value="boleta_honorarios">BH: Boleta Honorarios</option>
                <option value="boleta_electronica">BE: Boleta Electrónica</option>
            </select>
        </div>
        <div class="col-md-1">
            <button class="btn btn-outline-secondary" type="button" wire:click="refresh">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <div class="col-md-1">
            <div wire:loading>
                <div class="spinner-border"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col text-center">

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
                <th>Recepción</th>
                <th width="190">Admin C.</th>
                <th width="90">Fecha Aceptación SII (días)</th>
                <th>Devengo</th>
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
                                id="ids.{{ $dte->id }}" wire:model.defer="ids.{{ $dte->id }}">
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
                    </td>
                    <td class="small">
                        <!--
                            Acá deben ir tres cosas.
                            1. Actas de recepción emitidas en el módulo de cenabast
                            2. Actas de recepción emitidas y firmadas en bodega
                            3. Actas de recepción de servicios emitidas en abastecimiento

                            Todo lo anterior se reemplaza por recepciones (y)
                        -->

                        <!-- Punto 1 -->
                        {{--
                        @if ($dte->cenabast_reception_file)
                            <a class="btn btn-sm btn-outline-primary" target="_blank"
                                href="{{ route('warehouse.cenabast.download.signed', $dte) }}"
                                title="Acta de recepción CENABAST">
                                <i class="fas fa-file"></i> CNB
                            </a>
                        @endif
                        --}}

                        <!-- Punto 2 -->
                        <!-- Punto 3 -->

                        <!-- Esto ya no debería ir, está comentado -->
                        {{-- 
                        @foreach ($dte->controls as $control)
                            <a class="btn btn-sm btn-outline-primary"
                                href="{{ route('warehouse.control.show', $control) }}" target="_blank">
                                #{{ $control->id }}
                            </a>
                        @endforeach 
                        --}}



                        <!-- Nuevo módulo de Recepciones -->
                        @include('finance.payments.partials.receptions-info')

                    </td>
                    <td class="small">
                        {{ $dte->requestForm?->contractManager?->tinnyName }} <br>
                        {{ $dte->estado_reclamo }}
                    </td>
                    <td class="small">
                        {{ $dte->fecha_recepcion_sii ?? '' }} <br>
                        ({{ $dte->fecha_recepcion_sii ? $dte->fecha_recepcion_sii->diffInDays(now()) : '' }} días)
                    </td>
                    <td class="small">
                        {{ $dte->estado_devengo }}<br>
                        {{ $dte->folio_sigfe }}
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

                        <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="for_folio_oc">Folio OC</label>
                                    <input type="text" class="form-control" id="for_folio_oc"
                                        wire:model.defer="folio_oc">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="for_monto_total">Monto Total</label>
                                    <input type="text" class="form-control" id="for_folio_oc"
                                        wire:model.defer="monto_total" disabled>
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
                                                wire:model.defer="asociate_invoices">
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
                                    @break
                                @endswitch



                                <div class="form-group col-md-4">
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
                                        wire:model.defer="reason_rejection">
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
                        <select class="form-select" wire:model.defer="establishment_id">
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
