<div>
    @if($index == 'own' || $index == 'all')
        <div class="card card-body small">
            <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
            <div class="row">
                <fieldset class="form-group col-12 col-md-1">
                    <label for="for_id">ID</label>
                    <input class="form-control form-control-sm" type="number" name="id_search" autocomplete="off" 
                        placeholder="001" wire:model.live.debounce.500ms="selectedId">
                </fieldset>
                
                <fieldset class="form-group col-12 col-md-2">
                    <label for="for_status_search">Estado Formulario</label>
                    <select name="status_search" class="form-select form-select-sm" wire:model.live.debounce.500ms="selectedStatus">
                        <option value="">Seleccione...</option>
                        <option value="save">Guardado</option>
                        <option value="sent">Enviado</option>
                        <option value="approved">Aprobado</option>
                        <option value="rejected">Rechazado</option>
                        <option value="published">Publicado</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-12 col-md-3">
                    <label for="for_subject">Asunto</label>
                    <input class="form-control form-control-sm" type="text" autocomplete="off" name="subject_search" 
                        wire:model.live.debounce.500ms="selectedSubject">
                </fieldset>

                <fieldset class="form-group col-12 col-md-3">
                    <label for="regiones">Periodo de Creación</label>
                    <div class="input-group">
                        <input type="date" class="form-control form-control-sm" name="start_date_search" wire:model.live.debounce.500ms="selectedStartDate">
                        <input type="date" class="form-control form-control-sm" name="end_date_search" wire:model.live.debounce.500ms="selectedEndDate">
                    </div>
                </fieldset>

                <fieldset class="form-group col-12 col-md-3">
                    <label for="for_user_creator">Usuario Creador</label>
                    <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder="NOMBRE / APELLIDOS"
                        name="user_creator_search" wire:model.live.debounce.500ms="selectedUserCreator">
                </fieldset>
            </div>

            <div class="row mt-3">
                <fieldset class="form-group col-12 col-md-3">
                    <label for="for_user_responsible">Usuario Responsable</label>
                    <input class="form-control form-control-sm" type="text" autocomplete="off" placeholder="NOMBRE / APELLIDOS"
                        name="user_responsible_search" wire:model.live.debounce.500ms="selectedUserResponsible">
                </fieldset>

                <fieldset class="form-group col-12 col-md-3">
                    <label for="for_requester_ou_id">U.O. Administrador Contrato</label>
                        @livewire('search-select-organizational-unit', [
                            'emit_name'          => 'searchedResponsibleOu',
                            'selected_id'        => 'responsible_ou_id',
                            'small_option'       => true,
                            'organizationalUnit' => null
                        ])
                </fieldset>

                <fieldset class="form-group col-12 col-md-3">
                    <label for="for_program">Programa</label>
                    <input class="form-control form-control-sm" type="text" autocomplete="off" name="program_search" wire:model.live.debounce.500ms="selectedProgram">
                </fieldset>
            </div>
        </div>
    @endif

    @if($index == 'own' || $index == 'all' || $this->index == 'pending' || $this->index == 'my_assigned_plans')
        <div class="row mb-3">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $purchasePlans->total() }}</b></p>
            </div>
            {{--<div class="col">
                <a class="btn btn-success btn-sm mb-1 float-right" onclick="tableExcel('reporte_plan_compras_{{Carbon\Carbon::now()}}')"><i class="fas fa-file-excel"></i> Exportar formularios</a></h6>
            </div>--}}
        </div>
        @if($purchasePlans->count() > 0)
            <div class="table-responsive ">
                <table class="table table-bordered table-sm small">
                    <thead>
                        <tr class="text-center align-top table-secondary">
                            <th width="6%">ID</th>
                            <th width="7%">
                                Fecha Creación
                                <span class="badge bg-info text-dark">Periodo</span>
                            </th>
                            <th width="">Asunto</th>
                            <th width="">Responsable</th>
                            <th width="">Programa</th>
                            <th width="120px">Estado</th>
                            <th width="85px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchasePlans as $purchasePlan)
                            <tr>
                                <th class="text-center">
                                    {{ $purchasePlan->id }}<br>
                                </th>
                                <td>
                                    {{ $purchasePlan->created_at->format('d-m-Y H:i:s') }}
                                    <span class="badge bg-info text-dark">{{ $purchasePlan->period }}</span><br>
                                </td>
                                <td>{{ $purchasePlan->subject }}</td>
                                <td>
                                    <b>{{ $purchasePlan->userResponsible->fullName }}</b><br>
                                    {{ $purchasePlan->organizationalUnit->name }} ({{$purchasePlan->organizationalUnit->establishment->name}})<br><br>
                                    
                                    creado por: <b>{{ $purchasePlan->userCreator->tinyName }}</b>
                                </td>
                                <td>{{ $purchasePlan->program }}</td>
                                <td class="text-center">
                                    @if($purchasePlan->status == 'save')
                                        <i class="fas fa-save fa-2x"></i>
                                    @else
                                        @foreach($purchasePlan->approvals as $approval)
                                            @switch($approval->StatusInWords)
                                                @case('Pendiente')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-clock fa-2x "></i>
                                                    </span>
                                                    @break
                                                @case('Aprobado')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: green;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-check-circle fa-2x"></i>
                                                    </span>
                                                    @break
                                                @case('Rechazado')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: tomato;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-times-circle fa-2x"></i>
                                                    </span>
                                                    @break
                                            @endswitch
                                        @endforeach
                                    @endif
                                    <br>
                                    <span class="badge bg-{{$purchasePlan->getColorStatus()}} badge-sm">{{ $purchasePlan->getStatus() }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('purchase_plan.show', $purchasePlan) }}"
                                        class="btn btn-outline-secondary btn-sm mb-1"><i class="fas fa-eye fa-fw"></i></a>
                                    @if($index == 'own')
                                        <a href="{{ route('purchase_plan.edit', $purchasePlan) }}"
                                            class="btn btn-outline-secondary btn-sm mb-1"><i class="fas fa-edit fa-fw"></i> </a>
                                    @endif
                                    @if($purchasePlan->canDelete() && ($index == 'all' || $index == 'own'))
                                        <button type="button" class="btn btn-outline-secondary btn-sm text-danger mb-1"
                                            onclick="confirm('¿Está seguro que desea borrar el plan de compra ID {{ $purchasePlan->id }}?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $purchasePlan }})"><i class="fas fa-trash fa-fw"></i>
                                        </button>
                                    @endif

                                    @if($purchasePlan->canAddPurchasePlanId() && $index == 'my_assigned_plans')
                                        <!-- Button trigger modal: Ingresar datos de Portal "Plan de Compras" -->
                                        <button type="button" class="btn btn-outline-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal-{{$purchasePlan->id }}">
                                            <i class="fas fa-upload fa-fw"></i>
                                        </button>

                                        @livewire('purchase-plan.add-purchase-plan', [
                                            'purchasePlan' =>   $purchasePlan 
                                        ])
                                    @endif

                                    @if($index == 'pending')
                                        @livewire('documents.approval-button', [
                                            'approval' => $purchasePlan->getApprovalPending(), 
                                            'redirect_route' => 'purchase_plan.pending_index', // (opcional) Redireccionar a una ruta despues de aprobar/rechazar
                                            'button_text' => null, // (Opcional) Texto del boton
                                            'button_size' => null, // (Opcional) Tamaño del boton: btn-sm, btn-lg, etc.
                                        ])
                                    @endif
                                    @if($index == 'own' && $purchasePlan->canCreateRquestForm())
                                    <a href="{{ route('request_forms.items.create', $purchasePlan) }}"
                                        class="btn btn-outline-secondary btn-sm mb-1"><i class="fas fa-file-invoice-dollar fa-fw"></i></a>
                                    @endif

                                    <!-- DOCUMENTO -->
                                    @if(count($purchasePlan->approvals) > 0 && $purchasePlan->approvals->last()->status == 1)
                                        <a href="{{ route('purchase_plan.documents.download_resol_pdf', $purchasePlan) }}"
                                            class="btn btn-sm btn-outline-primary mb-1" target="_blank"
                                            title="Ver documento">
                                            <span class="fas fa-file-pdf fa-fw" aria-hidden="true"></span>
                                        </a>
                                    @else
                                        <a href=""
                                            class="btn btn-sm btn-outline-secondary disabled mb-1" target="_blank"
                                            title="Ver documento">
                                            <span class="fas fa-file-pdf fa-fw" aria-hidden="true"></span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $purchasePlans->appends(request()->query())->links() }}
        @else
            <div class="alert alert-info" role="alert">
                Estimado Usuario: No se encuentran <b>Plan de Compras</b> bajo los parametros consultados.
            </div>
        @endif
    @endif
    
    @if($index == 'report: ppl-items')
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $purchasePlans->total() }}</b></p>
            </div>
        </div>
        @if($purchasePlans->count() > 0)                                
            <div class="table-responsive">
                <table id="contenedor" class="table table-bordered table-sm small">
                    <thead>
                        <tr class="text-center align-top table-secondary">
                            <th rowspan="2">ID</th>
                            <th rowspan="2">Fecha Creación</th>
                            <th rowspan="2">Periodo</th>
                            <th rowspan="2">Asunto</th>
                            <th rowspan="2">Descripción</th>
                            <th rowspan="2">Propósito</th>
                            <th rowspan="2">Responsable</th>
                            <th rowspan="2">Cargo</th>
                            <th rowspan="2">Teléfono</th>
                            <th rowspan="2">Correo electrónico</th>
                            <th rowspan="2">Unidad Organizacional</th>
                            <th rowspan="2">Creado por</th>
                            <th rowspan="2">Programa</th>
                            <th rowspan="2">Items</th>
                            <th rowspan="2">Presupuesto</th>
                            <th rowspan="2">Estado</th>
                            <!-- ITEMS -->
                            <th rowspan="2">N° Item</th>
                            <th rowspan="2">ID</th>
                            <!-- <th rowspan="2">Item Presupuestario</th> -->
                            <th rowspan="2">Artículo</th>
                            <th rowspan="2">UM</th>
                            <th rowspan="2">Especificaciones Técnicas</th>
                            <th rowspan="2">Cantidad</th>
                            <th rowspan="2">Valor U.</th>
                            <th rowspan="2">Impuestos</th>
                            <th rowspan="2">Total Item</th>
                            <th colspan="12">Cantidad programadas por meses</th>                       
                        </tr>
                        <tr class="text-center align-top table-secondary">
                            <th>Ene</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Abr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th>Jul</th>
                            <th>Ago</th>
                            <th>Sep</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dic</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchasePlans as $purchasePlan)
                            @foreach($purchasePlan->purchasePlanItems as $item)
                                <tr>
                                    <td rowspan="2">{{ $purchasePlan->id }}</td>
                                    <td rowspan="2">{{ $purchasePlan->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td rowspan="2">{{ $purchasePlan->period }}</td>
                                    <td rowspan="2">{{ $purchasePlan->subject }}</td>
                                    <td rowspan="2">{{ $purchasePlan->description }}</td>
                                    <td rowspan="2">{{ $purchasePlan->purpose }}</td>
                                    <td rowspan="2">{{ $purchasePlan->userResponsible->fullName }}</td>
                                    <td rowspan="2">{{ $purchasePlan->position }}</td>
                                    <td rowspan="2">{{ $purchasePlan->telephone }}</td>
                                    <td rowspan="2">{{ $purchasePlan->email }}</td>
                                    <td rowspan="2">{{ $purchasePlan->organizationalUnit->name }} ({{$purchasePlan->organizationalUnit->establishment->name}})</td>
                                    <td rowspan="2">{{ $purchasePlan->userCreator->tinyName }}</td>
                                    <td rowspan="2">{{ $purchasePlan->program }}</td>
                                    <td rowspan="2" class="text-center">{{ $purchasePlan->purchasePlanItems->count() }}</td>
                                    <td rowspan="2" class="text-end">{{ $purchasePlan->symbol_currency }}{{ number_format($purchasePlan->estimated_expense,$purchasePlan->precision_currency,",",".") }}</td>
                                    <td rowspan="2">{{ $purchasePlan->getStatus() }}</td>
                                    <td rowspan="2" class="text-center">{{ $loop->iteration }}</td>
                                    <td rowspan="2" class="text-end">{{ $item->id ?? '' }}</td>
                                    {{--<td rowspan="2" class="text-end" nowrap>{{ $item->budgetItem ? $item->budgetItem->fullName() : '' }}</td>--}}
                                    <td rowspan="2">{{ optional($item->unspscProduct)->code }} {{ optional($item->unspscProduct)->name }}</td>
                                    <td rowspan="2" class="text-center">{{ $item->unit_of_measurement }}</td>
                                    <td rowspan="2">{{ $item->specification }}</td>
                                    <td rowspan="2" class="text-center">{{ $item->quantity }}</td>
                                    <td rowspan="2" class="text-end">{{ str_replace(',00', '', number_format($item->unit_value, 2,",",".")) }}</td>
                                    <td rowspan="2" class="text-center">{{ $item->tax }}</td>
                                    <td rowspan="2" class="text-end">{{ number_format($item->expense, $item->precision_currency,",",".") }}</td>
                                </tr>
                                <tr>
                                    <td>{{$item->january}}</td>
                                    <td>{{$item->february}}</td>
                                    <td>{{$item->march}}</td>
                                    <td>{{$item->april}}</td>
                                    <td>{{$item->may}}</td>
                                    <td>{{$item->june}}</td>
                                    <td>{{$item->july}}</td>
                                    <td>{{$item->august}}</td>
                                    <td>{{$item->september}}</td>
                                    <td>{{$item->october}}</td>
                                    <td>{{$item->november}}</td>
                                    <td>{{$item->december}}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Estimado Usuario: No se encuentran <b>Plan de Compras</b> bajo los parametros consultados.
            </div>
        @endif
    @endif

    @if($index == 'assign_purchaser')
        <h6><i class="fas fa-inbox fa-fw"></i> Solicitudes pendientes de asignación</h6>
        @if($pendingPurchasePlans->count() > 0)
            <div class="row mt-3">
                <div class="col">
                    <p class="font-weight-lighter"><small>Total de Registros pendientes: <b>{{ $pendingPurchasePlans->total() }}</b></small></p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm small">
                    <thead>
                        <tr class="text-center align-top table-secondary">
                            <th width="3%">ID</th>
                            <th width="8%">
                                Fecha Creación
                                <span class="badge bg-info text-dark">Periodo</span>
                            </th>
                            <th width="20%">Asunto</th>
                            <th width="32%">Responsable</th>
                            <th width="20%">Programa</th>
                            <th width="13%">Estado</th>
                            <th width="4%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingPurchasePlans as $purchasePlan)
                            <tr>
                                <th class="text-center">
                                    {{ $purchasePlan->id }}<br>
                                </th>
                                <td class="text-center">
                                    {{ $purchasePlan->created_at->format('d-m-Y H:i:s') }}
                                    <br>
                                    <span class="badge bg-info text-dark">{{ $purchasePlan->period }}</span><br>
                                </td>
                                <td>{{ $purchasePlan->subject }}</td>
                                <td>
                                    <b>{{ $purchasePlan->userResponsible->fullName }}</b><br>
                                    {{ $purchasePlan->organizationalUnit->name }} ({{$purchasePlan->organizationalUnit->establishment->name}})<br><br>
                                        
                                    <small>creado por: <b>{{ $purchasePlan->userCreator->tinyName }}</b></small>
                                </td>
                                <td>{{ $purchasePlan->program }}</td>
                                <td class="text-center">
                                    @if($purchasePlan->status == 'save')
                                        <i class="fas fa-save fa-2x"></i>
                                    @else
                                        @foreach($purchasePlan->approvals as $approval)
                                            @switch($approval->StatusInWords)
                                                @case('Pendiente')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-clock fa-2x "></i>
                                                    </span>
                                                    @break
                                                @case('Aprobado')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: green;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-check-circle fa-2x"></i>
                                                    </span>
                                                    @break
                                                @case('Rechazado')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: tomato;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-times-circle fa-2x"></i>
                                                        
                                                    </span>
                                                    @break
                                            @endswitch
                                        @endforeach
                                    @endif
                                    <br>
                                    <span class="badge bg-{{$purchasePlan->getColorStatus()}} badge-sm">{{ $purchasePlan->getStatus() }}</span>
                                </td>
                                <td class="text-left text-center">
                                    <a href="{{ route('purchase_plan.show', $purchasePlan) }}"
                                        class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye fa-fw"></i></a>    
                                    <!-- Button trigger modal: Ingresar datos de Portal "Plan de Compras" -->
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-assign-{{$purchasePlan->id }}">
                                        <i class="fas fa-user fa-fw"></i>
                                    </button>
                                        
                                    @livewire('purchase-plan.assign-purchase-plan', [
                                        'purchasePlan' =>   $purchasePlan 
                                    ])
                                        
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pendingPurchasePlans->appends(request()->query())->links() }}
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Estimado Usuario: No se encuentran <b>Plan de Compras</b> bajo los parametros consultados.
            </div>
        @endif
        
        <h6 class="mt-4"><i class="fas fa-inbox fa-fw"></i> Solicitudes asignadas</h6>
        @if($assignedPurchasePlans->count() > 0)
            <div class="row">
                <div class="col">
                    <p class="font-weight-lighter"><small>Total de Registros asignados: <b>{{ $assignedPurchasePlans->total() }}</b></small></p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-sm small">
                    <thead>
                        <tr class="text-center align-top table-secondary">
                            <th width="3%">ID</th>
                            <th width="8%">
                                Fecha Creación
                                <span class="badge bg-info text-dark">Periodo</span>
                            </th>
                            <th width="20%">Asunto</th>
                            <th width="32%">Responsable</th>
                            <th width="20%">Programa</th>
                            <th width="13%">Estado</th>
                            <th width="4%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedPurchasePlans as $purchasePlan)
                            <tr>
                                <th class="text-center">
                                    {{ $purchasePlan->id }}<br>
                                </th>
                                <td>
                                    {{ $purchasePlan->created_at->format('d-m-Y H:i:s') }}
                                    <span class="badge bg-info text-dark">{{ $purchasePlan->period }}</span><br>
                                </td>
                                <td>{{ $purchasePlan->subject }}</td>
                                <td>
                                    <b>{{ $purchasePlan->userResponsible->fullName }}</b><br>
                                    {{ $purchasePlan->organizationalUnit->name }} ({{$purchasePlan->organizationalUnit->establishment->name}})<br><br>
                                        
                                    <small>creado por: <b>{{ $purchasePlan->userCreator->tinyName }}</b></small>
                                </td>
                                <td>{{ $purchasePlan->program }}</td>
                                <td class="text-center">
                                    @if($purchasePlan->status == 'save')
                                        <i class="fas fa-save fa-2x"></i>
                                    @else
                                        @foreach($purchasePlan->approvals as $approval)
                                            @switch($approval->StatusInWords)
                                                @case('Pendiente')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-clock fa-2x "></i>
                                                    </span>
                                                    @break
                                                @case('Aprobado')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: green;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-check-circle fa-2x"></i>
                                                    </span>
                                                    @break
                                                @case('Rechazado')
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: tomato;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                        <i class="fas fa-times-circle fa-2x"></i>
                                                    </span>
                                                    @break
                                            @endswitch
                                        @endforeach
                                    @endif
                                    <br>
                                    <span class="badge bg-{{$purchasePlan->getColorStatus()}} badge-sm">{{ $purchasePlan->getStatus() }}</span>
                                    <br><br>
                                    <small nowrap>Asignado a: <b>{{ $purchasePlan->assignPurchaser->tinyName }}</b></small>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('purchase_plan.show', $purchasePlan) }}"
                                        class="btn btn-outline-secondary btn-sm mb-1"><i class="fas fa-eye fa-fw"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Estimado Usuario: No se encuentran <b>Plan de Compras</b> bajo los parametros consultados.
            </div>
        @endif
    @endif
</div>

@section('custom_js')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>
<script>
    function tableExcel(filename, type, fn, dl) {
          var elt = document.getElementById('contenedor');
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS", raw: false });
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        }
</script>
@endsection