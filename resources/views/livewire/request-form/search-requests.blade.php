<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_status_search">Estado Formulario</label>
                <select name="status_search" class="form-control form-control-sm" wire:model.debounce.500ms="selectedStatus">
                    <option value="">Seleccione...</option>
                    <option value="saved">Guardado</option>
                    <option value="pending">Pendiente</option>
                    <option value="Approved">Aprobado</option>
                    <option value="rejected">Rechazado</option>
                </select>
            </fieldset>  

            <fieldset class="form-group col-12 col-md-2">
                <label for="for_status_purchase_search">Estado Proceso Compra</label>
                <select name="status_purchase_search" class="form-control form-control-sm" wire:model.debounce.500ms="selectedStatusPurchase">
                    <option value="">Seleccione...</option>
                    <option value="canceled">Anulado</option>
                    <option value="finalized">Finalizado</option>
                    <option value="in_process">En proceso</option>
                    <option value="purchased">Comprado</option>
                </select>
            </fieldset>
            
            <fieldset class="form-group col-12 col-md-1">
                <label for="for_id">ID</label>
                <input class="form-control form-control-sm" type="number" name="id_search" autocomplete="off" 
                    placeholder="001" wire:model.debounce.500ms="selectedId">
            </fieldset>

            <fieldset class="form-group col-12 col-md-1">
                <label for="for_folio">Folio</label>
                <input class="form-control form-control-sm" type="text" name="folio_search" autocomplete="off" 
                    placeholder="2022-17" wire:model.debounce.500ms="selectedFolio">
            </fieldset>

            <fieldset class="form-group col-12 col-md-3">
                <label for="for_name">Descripción</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off"
                    name="name_search" wire:model.debounce.500ms="selectedName">
            </fieldset>

            <fieldset class="form-group col-12 col-md-3">
                <label for="regiones">Periodo de Creación</label>
                <div class="input-group">
                    <input type="date" class="form-control form-control-sm" name="start_date_search" wire:model.debounce.500ms="selectedStartDate">
                    <input type="date" class="form-control form-control-sm" name="end_date_search" wire:model.debounce.500ms="selectedEndDate">
                </div>
            </fieldset>
        
        </div>
        
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_requester">Usuario Gestor</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder="NOMBRE / APELLIDOS"
                    name="requester_search" wire:model.debounce.500ms="selectedRequester">
            </fieldset>
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_ou_requester">U.O. Usuario Gestor</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder=""
                    name="ou_requester_search"  disabled>
            </fieldset>
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_requester">Administrador Contrato</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder="NOMBRE / APELLIDOS"
                    name="admin_search" wire:model.debounce.500ms="selectedAdmin">
            </fieldset>
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_ou_requester">U.O. Administrador Contrato</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder=""
                    name="ou_admin_search" disabled>
            </fieldset>
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_purchaser">Comprador</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder="NOMBRE / APELLIDOS"
                    name="purchaser_search" wire:model.debounce.500ms="selectedPurchaser">
            </fieldset>
            <fieldset class="form-group col-12 col-md-2">
                <label for="for_purchaser">Programa</label>
                <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder=""
                    name="program_search" wire:model.debounce.500ms="selectedProgram">
            </fieldset>
        </div>
        
    </div>

    <br>

    @if($request_forms->count() > 0)
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $request_forms->total() }}</b></p>
            </div>
            <div class="col">
                <a class="btn btn-success btn-sm mb-1 float-right" wire:click="export"><i class="fas fa-file-excel"></i> Exportar formularios</a></h6>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover small">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Folio</th>
                        <th style="width: 7%">Fecha Creación</th>          
                        <th>Tipo / Mecanismo de Compra</th>
                        <th>Descripción</th>
                        <th>Usuario Gestor</th>
                        <th>Comprador</th>
                        <th>Items</th>
                        <th>Presupuesto</th>
                        <th>Espera</th>
                        <th>Etapas de aprobación</th>
                        <th style="width: 7%">Fecha de Aprobación Depto de Gestión de Abastecimiento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($request_forms as $requestForm)
                    <tr>
                        <th>{{ $requestForm->id }} <br>
                            @switch($requestForm->getStatus())
                                @case('Pendiente')
                                    <i class="fas fa-clock"></i>
                                @break

                                @case('Aprobado')
                                    <span style="color: green;">
                                    <i class="fas fa-check-circle" title="{{ $requestForm->getStatus() }}"></i>
                                    </span>
                                    @if($requestForm->purchasingProcess)
                                        <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->getStatus()}}</span>
                                    @else
                                        <span class="badge badge-warning">En proceso</span>
                                    @endif
                                @break$
                                @case('Rechazado')
                                    <a href="">
                                        <span style="color: Tomato;">
                                            <i class="fas fa-times-circle" title="{{ $requestForm->getStatus() }}"></i>
                                        </span>
                                    </a>
                                @break
                            @endswitch
                        </th>
                        <td>
                            <a href="{{ route('request_forms.show', $requestForm->id) }}">{{ $requestForm->folio }}</a>
                                @if($requestForm->father)
                                <br>(<a href="{{ route('request_forms.show', $requestForm->father->id) }}">{{ $requestForm->father->folio }}</a>)
                                @endif
                        </td>
                        <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>          
                        <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                            {{ $requestForm->SubtypeValue }}
                        </td>
                        <td>{{ $requestForm->name }}</td>
                        <td>{{ $requestForm->user ? $requestForm->user->FullName : 'Usuario eliminado' }}<br>
                            {{ $requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                        </td>
                        <td>{{ $requestForm->purchasers->first()->FullName?? 'No asignado' }}</td>
                        <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                        <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                        <td align="center">{{ $requestForm->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            @if($requestForm->eventRequestForms->count() > 0)
                                @foreach($requestForm->eventRequestForms as $sign)
                                    @if($sign->status == 'pending' || $sign->status == NULL)
                                    <i class="fas fa-clock fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                    @endif
                                    @if($sign->status == 'approved')
                                    <span style="color: green;">
                                    <i class="fas fa-check-circle fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                    </span>
                                    @endif
                                    @if($sign->status == 'rejected')
                                    <span style="color: Tomato;">
                                    <i class="fas fa-times-circle fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                    </span>
                                    @endif
                                    @if($sign->status == 'does_not_apply')
                                    <i class="fas fa-ban fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                    @endif
                                @endforeach
                            @else
                                <i class="fas fa-save fa-2x"></i>
                            @endif
                        </td>
                        @php($dateSupplyEvent = $requestForm->eventRequestForms->where('event_type', 'supply_event')->where('status', 'approved')->last())
                        <td>{{ $dateSupplyEvent ? $dateSupplyEvent->signature_date->format('d-m-Y H:i') : 'No se ha firmado Documento' }}</td>

                        <td>
                            <a href="{{ route('request_forms.show', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Mostrar"><i class="fas fa-eye"></i>
                            </a>
                            @if(Auth()->user()->hasPermissionTo('Request Forms: all'))
                            <a href="{{ route('request_forms.edit', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Edición"><i class="fas fa-edit"></i>
                            </a>
                            @endif
                            @if(Auth()->user()->hasPermissionTo('Request Forms: all') and $requestForm->status == 'approved')
                            <!-- Button trigger modal -->            
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#exampleModal-{{ $requestForm->id }}" title="Reasignar comprador">
                            <i class="fas fa-redo"></i>
                            </button>
                            @include('request_form.purchase.modals.reasign_purchaser')
                            @endif
                            
                            @if($requestForm->signatures_file_id)
                            <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado" href="{{ $requestForm->signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->first() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 1]) }}" target="_blank" title="Certificado">
                            <i class="fas fa-file-contract"></i>
                            </a>
                            @endif

                            @if($requestForm->old_signatures_file_id)
                            <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anterior firmado" href="{{ $requestForm->old_signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->first() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}" target="_blank" title="Certificado">
                            <i class="fas fa-file-contract"></i>
                            </a>
                            @endif

                            @if(Auth()->user()->hasPermissionTo('Request Forms: all') && Str::contains($requestForm->subtype, 'tiempo') && !$requestForm->isBlocked() && $requestForm->status == 'approved')
                            <a onclick="return confirm('¿Está seguro/a de crear nuevo formulario de ejecución inmediata?')" href="{{ route('request_forms.create_provision', $requestForm->id) }}" class="btn btn-outline-secondary btn-sm" title="Nuevo formulario de ejecución inmediata"><i class="fas fa-plus"></i>
                            </a>
                            @endif

                            @if(Auth()->user()->hasPermissionTo('Request Forms: all') && $requestForm->purchasingProcess)
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                            <a href="{{ route('request_forms.supply.purchase', $requestForm) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-shopping-cart"></i></a>
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $request_forms->appends(request()->query())->links() }}
    @else
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $request_forms->total() }}</b></p>
            </div>
        </div>

        <div class="alert alert-info" role="alert">
            <b>Estimado usuario</b>: No se encuentran solicitudes bajo los parámetros consultados.
        </div>
    @endif
</div>
