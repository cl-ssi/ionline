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
            <select class="form-control" wire:model.defer="filter.sender_status" disabled>
                <option value="Todas">Todas</option>
                <option value="No Confirmadas">No Confirmadas</option>
                <option value="Confirmadas">Confirmadas</option>
                <option value="Rechazadas">Rechazadas</option>
                <option value="Sin Envío">Sin Envío</option>
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
                <th>Bod</th>
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
                            <input class="form-check-input position-static" 
                                style="scale: 1.5;"
                                type="checkbox" 
                                id="ids.{{$dte->id}}" 
                                wire:model.defer="ids.{{$dte->id}}">
                        </div>
                        @endcannot
                    </td>
                    <td>
                        {{ $dte->establishment?->alias }}
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" 
                                class="custom-control-input" 
                                id="customSwitch{{$dte->id}}"
                                wire:click="toggleCenabast({{$dte->id}})"
                                wire:loading.attr="disabled"
                                wire:loading.class="spinner-border"
                                wire:target="toggleCenabast({{$dte->id}})"
                                {{ $dte->cenabast ? 'checked' : '' }}
                                @can('Payments: viewer')
                                disabled
                                @endcan
                                >
                            <label class="custom-control-label" for="customSwitch{{$dte->id}}"></label>
                        </div>
                    </td>
                    <td class="small">
                        @if ($dte->tipo_documento != 'boleta_honorarios')
                            @if($dte->uri)
                            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}"
                                target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                            @else
                                Es un documento cargado manualmente
                            @endif
                        @else
                            <a href="{{ $dte->uri }}" target="_blank"
                                class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @endif
                        <br>
                        {{ $dte->tipo_documento }}

                        @foreach($dte->dtes as $dteAsociate)
                            @if ($dteAsociate->tipo_documento != 'boleta_honorarios')
                                <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dteAsociate->uri }}"
                                    target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                    <i class="fas fa-file-pdf text-danger"></i> {{ $dteAsociate->folio }}
                                </a>
                            @else
                                <a href="{{ $dteAsociate->uri }}" target="_blank"
                                    class="btn btn-sm mb-1 btn-outline-secondary">
                                    <i class="fas fa-file-pdf text-danger"></i> {{ $dteAsociate->folio }}
                                </a>
                            @endif
                            <br>
                            {{ $dteAsociate->tipo_documento }}
                        @endforeach
                        <br>
                        {{ $dte->emisor }}
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
                            <button class="btn btn-sm btn-primary" wire:click="show({{$dte->id}})">
                                <i class="fas fa-edit"></i>
                            </button>
                        @endcannot
                    </td>

                </tr>

                @if($showEdit == $dte->id)
                <tr>
                    <td colspan="11">

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="for_folio_oc">Folio OC</label>
                                <input type="text" class="form-control" id="for_folio_oc" wire:model.defer="folio_oc">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="for_monto_total">Monto Total</label>
                                <input type="text" class="form-control" id="for_folio_oc" wire:model.defer="monto_total" disabled>
                            </div>
                            @switch($dte->tipo_documento)
                                @case('guias_despacho')
                                @case('nota_credito')
                                @case('nota_debito')
                                    <div class="form-group col-md-5">
                                        <label for="for_asociate">Asociar a Factura</label>
                                        <select class="form-control" id="for_asociate" wire:model.defer="asociate_dte_id">
                                            <option></option>
                                            @foreach($facturasEmisor as $factura)
                                            <option value="{{ $factura->id }}">
                                                {{ $factura->folio }} ( $ {{ money($factura->monto_total) }} ) </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                        <button type="submit" 
                            class="btn btn-outline-secondary"
                            wire:click="dismiss">Cancelar</button>
                        <button type="submit" class="btn btn-primary"
                            wire:click="save({{$dte->id}})">Guardar</button>

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
