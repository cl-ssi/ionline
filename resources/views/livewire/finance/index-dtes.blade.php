<div>

    @include('finance.nav')


    <div class="row mb-3">
        <div class="col-6">
            <h3 class="mb-3">Listado de dtes cargadas en sistema</h3>
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


    <div class="form-row mb-3">
        <div class="col-md-2">
            <select class="form-control" wire:model.defer="filter.establishment">
                <option value="">Todos los Establecimientos</option>
                @foreach ($establishments as $name => $id)
                    <option value="{{ $name }}">{{ $id }}</option>
                @endforeach
                <option value="?">Sin establecimiento</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" wire:model.defer="filter.folio" placeholder="folio">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" wire:model.defer="filter.folio_oc" placeholder="oc">
        </div>
        <div class="col-md-2">
            <select class="form-control" wire:model.defer="filter.folio_sigfe">
                <option value="Todos">Todos</option>
                <option value="Sin Folio SIGFE">Sin Folio SIGFE</option>
                <option value="Con Folio SIGFE">Con Folio SIGFE</option>
            </select>
        </div>
        <div class="col-md-2">
            {{-- <select class="form-control" wire:model.defer="filter.sender_status" disabled>
                <option value="Todas">Todas</option>
                <option value="No Confirmadas">No Confirmadas</option>
                <option value="Confirmadas">Confirmadas</option>
                <option value="Rechazadas">Rechazadas</option>
                <option value="Sin Envío">Sin Envío</option>
            </select> --}}
            <select class="form-control" wire:model.defer="filter.tipo_documento">
                <option value="">Todas</option>
                <option value="factura_electronica">Factura Electrónica</option>
                <option value="factura_exenta">Factura Exenta</option>
                <option value="guias_despacho">Guias Despacho</option>
                <option value="nota_credito">Nota Crédito</option>
                <option value="boleta_electronica">Boleta Electrónica</option>
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
                <th>CNB.</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Bod/Recep</th>
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
                            <div class="form-check">
                                <input class="form-check-input position-static" style="scale: 1.5;" type="checkbox"
                                    id="ids.{{ $dte->id }}" wire:model.defer="ids.{{ $dte->id }}">
                            </div>
                        @endcannot
                    </td>
                    <td>
                        {{ $dte->establishment?->alias }}
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch{{ $dte->id }}"
                                wire:click="toggleCenabast({{ $dte->id }})" wire:loading.attr="disabled"
                                wire:loading.class="spinner-border" wire:target="toggleCenabast({{ $dte->id }})"
                                {{ $dte->cenabast ? 'checked' : '' }}
                                @can('Payments: viewer')
                                disabled
                                @endcan>
                            <label class="custom-control-label" for="customSwitch{{ $dte->id }}"></label>
                        </div>
                    </td>
                    <td class="small">
                        Emisor: {{ $dte->emisor }}
                        <br>

                        @if ($dte->tipo_documento != 'boleta_honorarios' or $dte->tipo_documento != 'boleta_electronica')
                            @if ($dte->uri)
                                <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}"
                                    target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                    <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                                </a>
                            @else
                                @if ($dte->archivo_carga_manual)
                                    <a  href="{{ route('finance.dtes.downloadManualDteFile', $dte) }}" target="_blank"
                                        target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                        <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                                    </a>
                                @endif
                            @endif
                        @else
                            <a href="{{ $dte->uri }}" target="_blank"
                                class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @endif
                        <br>
                        {{ $dte->tipo_documento }}

                        <hr>

                        @foreach ($dte->dtes as $dteAsociate)
                            @switch($dteAsociate->tipo_documento)
                                {{-- @case('factura_electronica') --}}
                                {{-- @case('factura_exenta') --}}
                                @case('guias_despacho')
                                @case('nota_debito')
                                @case('nota_credito')
                                    <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dteAsociate->uri }}"
                                        target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                        <i class="fas fa-file-pdf text-danger"></i> {{ $dteAsociate->folio }}
                                    </a>
                                    @break
                                @case('boleta_honorarios')
                                    <a href="{{ $dteAsociate->uri }}" target="_blank"
                                        class="btn btn-sm mb-1 btn-outline-secondary">
                                        <i class="fas fa-file-pdf text-danger"></i> {{ $dteAsociate->folio }}
                                    </a>
                                    @break
                                @case('boleta_electronica')
                                    @if($dteAsociate->archivo_carga_manual)
                                        <a  href="{{ route('finance.dtes.downloadManualDteFile', $dteAsociate) }}" target="_blank"
                                            target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                            <i class="fas fa-file-pdf text-danger"></i> {{ $dteAsociate->folio }}
                                        </a>
                                    @endif
                                    @break
                            @endswitch
                            <br>
                            {{ $dteAsociate->tipo_documento }}
                        @endforeach

                        @foreach ($dte->invoices as $invoiceAsociate)
                            @switch($invoiceAsociate->tipo_documento)
                                @case('factura_electronica')
                                @case('factura_exenta')
                                @case('guias_despacho')
                                @case('nota_debito')
                                @case('nota_credito')
                                    <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $invoiceAsociate->uri }}"
                                        target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                        <i class="fas fa-file-pdf text-danger"></i> {{ $invoiceAsociate->folio }}
                                    </a>
                                    @break
                                @case('boleta_honorarios')
                                    @if($invoiceAsociate->uri)
                                    <a href="{{ $invoiceAsociate->uri }}" target="_blank"
                                        class="btn btn-sm mb-1 btn-outline-secondary">
                                        <i class="fas fa-file-pdf text-danger"></i> {{ $invoiceAsociate->folio }}
                                    </a>
                                    @endif
                                    @break
                                @case('boleta_electronica')
                                    @if($invoiceAsociate->uri)
                                    <a  href="{{ route('finance.dtes.downloadManualDteFile', $invoiceAsociate) }}" target="_blank"
                                        target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                        <i class="fas fa-file-pdf text-danger"></i> {{ $invoiceAsociate->folio }}
                                    </a>
                                    @endif
                                    @break
                            @endswitch
                            <br> 
                            {{ $invoiceAsociate->tipo_documento }}
                            <br> 
                        @endforeach

                    </td>
                    <td class="small">
                        {{-- $dte->folio_oc --}}
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
                        <!--
                            Acá deben ir tres cosas.
                            1. Actas de recepción emitidas en el módulo de cenabast
                            2. Actas de recepción emitidas y firmadas en bodega
                            3. Actas de recepción de servicios emitidas en abastecimiento
                        -->

                        <!-- Punto 1 -->
                        @if ($dte->cenabast_reception_file)
                            <a class="btn btn-sm btn-outline-primary" target="_blank"
                                href="{{ route('warehouse.cenabast.download.signed', $dte) }}"
                                title="Acta de recepción CENABAST">
                                <i class="fas fa-file"></i> CNB
                            </a>
                        @endif

                        <!-- Punto 2 -->
                        <!-- Punto 3 -->

                        <!-- Esto ya no debería ir -->
                        @foreach ($dte->controls as $control)
                            <a class="btn btn-sm btn-outline-primary"
                                href="{{ route('warehouse.control.show', $control) }}" target="_blank">
                                #{{ $control->id }}
                            </a>
                        @endforeach
                    </td>
                    <td class="small">
                        {{ $dte->requestForm?->contractManager?->tinnyName }} <br>
                        {{ $dte->estado_reclamo }}
                        {{-- 
                            @if ($dte->requestForm)
                                @if ($dte->requestForm->contractManager)
                                    {{ $dte->requestForm->contractManager->shortName }} <br>
                                    @livewire('finance.dte-send-confirmation', ['dte' => $dte->id, 'user_id' => $dte->requestForm->contract_manager_id], key($dte->id))
                                @endif
                            @endif
                        --}}
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

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="for_folio_oc">Folio OC</label>
                                    <input type="text" class="form-control" id="for_folio_oc"
                                        wire:model.defer="folio_oc">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="for_monto_total">Monto Total</label>
                                    <input type="text" class="form-control" id="for_folio_oc" wire:model.defer="monto_total" disabled>
                                </div>
                                @switch($dte->tipo_documento)
                                    @case('guias_despacho')
                                    @case('nota_credito')
                                    @case('nota_debito')
                                        <!-- TODO: Si es guia, se puede asociar a multiple
                                            si es nota de crédito o débito se debería poder asociar sólo a una 
                                            preguntar a gina o juan toro -->
                                        <div class="form-group col-md-5">
                                            <label for="for_asociate">Asociar a Factura</label>
                                            <select multiple  class="form-control" id="for_asociate" wire:model.defer="asociate_invoices">
                                                @foreach($facturasEmisor as $factura)
                                                <option value="{{ $factura->id }}">
                                                    {{ $factura->folio }} ( $ {{ money($factura->monto_total) }} ) </option>
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

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="for_confirmation_status">Estado de confirmación</label>
                                    <select class="form-control" id="for_confirmation_status"
                                        wire:model.defer="confirmation_status">
                                        <option value=""></option>
                                        <option value="0">Rechazar</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-9">
                                    <label for="for_confirmation_observation">Observación</label>
                                    <textarea class="form-control" wire:model.defer="confirmation_observation" rows="3"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-secondary"
                                wire:click="dismiss">Cancelar</button>
                            <button type="submit" class="btn btn-primary"
                                wire:click="save({{ $dte->id }})">Guardar</button>

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
                <div class="form-row">
                    <div class="col-3">
                        <select class="form-control" wire:model.defer="establishment_id">
                            <option value=""></option>
                            @foreach ($establishments as $name => $id)
                                <option value="{{ $name }}">{{ $id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" wire:click="setEstablishment">
                        Asignar establecimiento
                    </button>
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
