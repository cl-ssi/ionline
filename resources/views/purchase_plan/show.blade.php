@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-12">
        <h5 class="mb-3">
            <i class="fas fa-shopping-cart"></i> Plan de Compra: ID {{ $purchasePlan->id }} 
            <span class="badge bg-{{$purchasePlan->getColorStatus()}} badge-sm">{{ $purchasePlan->getStatus() }}</span>
        </h5>
    </div>
</div>

<br>

<h6><i class="fas fa-info-circle"></i> 1. Descripción</h6>
<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr>
                <th width="30%" class="table-secondary">Asunto</th>
                <td class="text-left">{{ $purchasePlan->subject }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Descripción general del proyecto o adquisición</th>
                <td class="text-left">{{ $purchasePlan->description }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Propósito general del proyecto o adquisición</th>
                <td class="text-left">{{ $purchasePlan->purpose }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Funcionario Responsable</th>
                <td class="text-left">{{ $purchasePlan->userResponsible->fullName }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Cargo</th>
                <td class="text-left">{{ $purchasePlan->position }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Teléfono</th>
                <td>{{ $purchasePlan->telephone }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Correo Electronico</th>
                <td>{{ $purchasePlan->email }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Depto./Unidad</th>
                <td class="text-left">{{ $purchasePlan->organizationalUnit->name }} ({{$purchasePlan->organizationalUnit->establishment->name}})</td>
            </tr>
            <tr>
                <th class="table-secondary">Nombre del Programa o Presupuesto Designado</th>
                <td>{{ $purchasePlan->program }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Monto Solicitado (Aproximado)</th>
                <td>${{ number_format($purchasePlan->estimated_expense, 0, ",", ".") }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Monto aprobado</th>
                <td></td>
            </tr>
            <tr>
                <th class="table-secondary">Asigando a: (Comprador)</th>
                <td>{{ $purchasePlan->assignPurchaser?->fullName }}</td>
            </tr>
        </thead>
    </table>
</div>

@if($purchasePlan->canAddPurchasePlanId() && $purchasePlan->assign_user_id == auth()->id())
    <!-- Button trigger modal: Ingresar datos de Portal "Plan de Compras" -->
    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal-{{$purchasePlan->id }}">
        <i class="fas fa-upload fa-fw"></i> Ingresar ID Mercado Público
    </button>

    @livewire('purchase-plan.add-purchase-plan', [
        'purchasePlan' =>   $purchasePlan 
    ])
@endif

@if($purchasePlan->purchasePlanPublications->count() > 0)
    <h6><i class="fas fa-info-circle mt-4"></i> Publicación Mercado Público</h6>
    <div class="table-responsive">
        <table class="table table-bordered table-sm small">
            <thead>
                <tr class="text-center table-secondary">
                    <th width="5%">#</th>
                    <th width="10%">Fecha Ingreso</th>
                    <th width="30%">ID Mercado Público</th>
                    <th width="30%">Fecha Publicación</th>
                    <th width="30%">Adjunto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchasePlan->purchasePlanPublications as $purchasePlanPublication)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $purchasePlanPublication->created_at }}</td>
                        <td class="text-center">{{ $purchasePlanPublication->mercado_publico_id }}</td>
                        <td class="text-center">{{ $purchasePlanPublication->date }}</td>
                        <td class="text-center">
                            <a class="btn btn-outline-primary" href="{{ route('purchase_plan.show_file', $purchasePlanPublication) }}" target="_blank">
                                <i class="fas fa-paperclip fa-fw"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>  
@endif


{{--@if($purchasePlan->canEdit())
<div class="row">
    <div class="col">
        <a class="btn btn-primary float-end btn-sm"
            href="{{ route('purchase_plan.edit', $purchasePlan) }}">
            <i class="fas fa-edit"></i> Editar
        </a>
    </div>
</div>
@endif--}}

<br>

<div class="row mt-3"> 
    <div class="col">
        <h6><i class="fas fa-info-circle"></i> 2. Ítems a comprar</h6>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr class="text-center">
                <th width="" class="table-secondary" rowspan="2">#</th>
                {{-- <th width="" class="table-secondary" rowspan="2">Item</th> --}}
                <th width="" class="table-secondary" rowspan="2">Artículo</th>
                <th width="" class="table-secondary" rowspan="2">UM</th>
                <th width="" class="table-secondary" rowspan="2">Especificaciones Técnicas</th>
                {{--<th width="" class="table-secondary" rowspan="2">Archivo</th>--}}
                <th width="" class="table-secondary" colspan="2">Cantidad</th>
                <th width="" class="table-secondary" rowspan="2">Valor U.</th>
                <th width="" class="table-secondary" rowspan="2">Impuestos</th>
                <th width="" class="table-secondary" rowspan="2">Total Item</th>
                <th width="8%" class="table-secondary" rowspan="2"><small>Acciones / Fecha Eliminación</small></th>
            </tr>
            <tr>
                <th class="table-secondary">Solicitados</th>
                <th class="table-secondary">Programados</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchasePlan->purchasePlanItemsWithTrashed as $item)
            <tr class="text-center {{ ($item->deleted_at != NULL) ? 'table-danger' : '' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->unspscProduct->name }}</td>
                <td>{{ $item->unit_of_measurement }}</td>
                <td>{{ $item->specification }}</td>
                {{--<td></td>--}}
                <td>{{ $item->quantity }}</td>
                <td class="{{ $item->quantity > $item->scheduled_quantity ? 'text-danger' : 'text-success' }}">{{ $item->scheduled_quantity }}</td>
                <td class="text-end">${{ number_format($item->unit_value, 0, ",", ".") }}</td>
                <td>{{ $item->tax }}</td>
                <td class="text-end">${{ number_format($item->expense, 0, ",", ".") }}</td>
                <td>
                    @if($item->deleted_at == NULL)
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-ppl-{{ $item->id }}">
                            <i class="fas fa-calendar-alt fa-fw"></i>
                        </button>

                        {{--
                        <a type="button" 
                            class="btn btn-outline-danger btn-sm" 
                            onclick="return confirm('¿Está seguro que desea eliminar Ítem?')"
                            href="{{ route('purchase_plan.items.destroy', $item) }}">
                            <i class="fas fa-trash-alt fa-fw"></i>
                        </a>
                        --}}

                        @include('purchase_plan.modals.detail_month', [
                            'item' => $item
                        ])
                    @else
                        <small>{{ $item->deleted_at->format('d-m-Y H:i:s') }}</small>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7"></td>
                <th class="text-end">Total</th>
                <th class="text-end">${{ number_format($purchasePlan->estimated_expense, 0, ",", ".") }}</th>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

@if($purchasePlan->files->count() > 0)
    <div class="row mt-3"> 
        <div class="col-12 col-md-2">
            <h6><i class="fas fa-paperclip mt-2"></i> Adjuntos</h6>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm small" name="items">
            <thead>
                <tr class="bg-light text-center">
                    <th>#</th>
                    <th>Nombre archivo</th>
                    <th>Archivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchasePlan->files as $key => $file)
                <tr>
                    <td class="brd-l text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $file->name }}</td>
                    <td class="text-center">
                        <a class="btn btn-secondary btn-sm" 
                            title="Abrir" 
                            href="{{ route('purchase_plan.documents.show_attachment', $file) }}"
                            target="_blank">
                            <i class="fas fa-file"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<br>

<div class="row"> 
    <div class="col">
        <h6><i class="fas fa-info-circle"></i> 3. Aprobaciones</h6>
    </div>
</div>

@if($purchasePlan->approvals->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-sm small">
            <thead>
                <tr class="text-center">
                    @foreach($purchasePlan->approvals as $approval)
                    <th width="" class="table-secondary">{{ $approval->sentToOu->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    @foreach($purchasePlan->approvals as $approval)
                    <td>
                        @switch($approval->StatusInWords)
                            @case('Pendiente')
                                <i class="fas fa-clock"></i> {{ $approval->StatusInWords }}
                                @break
                            @case('Aprobado')
                                <span class="d-inline-block" style="color: green;">
                                    <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                                </span>
                                @break
                            @case('Rechazado')
                                <span class="d-inline-block" style="color: tomato;">
                                    <i class="fas fa-times-circle"></i> {{ $approval->StatusInWords }}
                                </span>
                                @break
                        @endswitch
                        <br>
                        @if($approval->StatusInWords == 'Aprobado' || $approval->StatusInWords == 'Rechazado')
                            <i class="fas fa-user"></i> {{ ($approval->approver) ? $approval->approver->fullName : '' }} <br>
                            <i class="fas fa-calendar-alt"></i> {{ ($approval->approver_at) ? $approval->approver_at->format('d-m-Y H:i:s') : '' }}
                            @if($approval->approver_observation)
                                <hr>
                                {{ $approval->approver_observation }}
                            @endif
                        @endif
                    </td>           
                    @endforeach
                </tr>
            <tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-12 col-md-12">                
            <button type="button" class="btn btn-primary btn-sm float-end" wire:click="sendNotificaction"><i class="fas fa-bell"></i> </button>
        </div>
    </div>
@else
    <div class="alert alert-info" role="alert">
        Estimado Usuario: El Plan de Compras aún no ha sido enviado para aprobaciones. Procure completar detalle de distribucion por item.  
        <a class="btn btn-sm btn-outline-success float-end pt-0" href="{{ route('purchase_plan.send', $purchasePlan) }}"><i class="fas fa-paper-plane"></i> Enviar</a>
    </div>
@endif

<div class="row mt-3"> 
    <div class="col">
        <h6><i class="fas fa-info-circle"></i> Historial de Ciclos de Aprobaciones</h6>
    </div>
</div>
{{--
<div class="row mt-3"> 
    <div class="col">
        <h6><i class="fas fa-info-circle"></i> Rechazos</h6>
    </div>
</div>
@if($purchasePlan->trashedApprovals->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-sm small">
            <thead>
                <tr class="text-center">
                    <th width="8%" class="table-secondary">Fecha</th>
                    <th width="" class="table-secondary">Motivo Rechazo</th>
                    <th width="20%" class="table-secondary">Usuario</th>
                    <th width="20%" class="table-secondary">Unidad Organizacional</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchasePlan->trashedApprovals as $approval)
                    @if($approval->status === 0)
                        <tr class="text-center">
                            <td>{{ ($approval->approver_at) ?  $approval->approver_at->format('d-m-Y H:i:s') : '' }}</td>
                            <td>{{ $approval->approver_observation }}</td> 
                            <td>{{ ($approval->approver) ? $approval->approver->fullName : '' }}</td>
                            <td>{{ $approval->sentToOu->name }}</td>         
                        </tr>
                    @endif
                @endforeach
            <tbody>
        </table>
    </div>
@else
<div class="alert alert-info" role="alert">
    <b>Estimado Usuario</b>: No existe registro de rechazos para este Plan de Compras.
</div>
@endif
--}}

<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <h6><i class="fas fa-info-circle"></i> Ciclos</h6>
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <table class="table table-bordered table-sm small">
                    <thead>
                        <tr class="text-center">
                            <th width="" class="table-secondary">Fecha Creación</th>
                            <th width="" class="table-secondary">Unidad Organizacional</th>
                            <th width="" class="table-secondary">Usuario</th>
                            <th width="" class="table-secondary">Fecha Aprobación</th>
                            <th width="" class="table-secondary">Estado</th>
                            <th width="" class="table-secondary">Fecha Eliminación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchasePlan->trashedApprovals as $approval)
                            <tr class="text-center table-{{ $approval->getColorAttribute() }} {{ ($approval->deleted_at != NULL) ? 'table-danger' : '' }}">
                                <td width="9%">{{ ($approval->created_at) ?  $approval->created_at->format('d-m-Y H:i:s') : '' }}</td>
                                <td>{{ $approval->sentToOu->name }}</td>
                                <td>{{ ($approval->approver) ? $approval->approver->name : '' }}</td>
                                <td width="9%">{{ ($approval->approver_at) ?  $approval->approver_at->format('d-m-Y H:i:s') : '' }}</td>
                                <td>{{ $approval->StatusInWords }}</td>
                                <td width="9%">{{ ($approval->deleted_at) ?  $approval->deleted_at->format('d-m-Y H:i:s') : '' }}</td>     
                            </tr>
                        @endforeach
                    </tbody>
            </div>
        </div>
    </div>
</div>

@if($purchasePlan->requestForms->count() > 0)
<br>
    <div class="row">
        <div class="col-sm">
            <div class="table-responsive">
                <h6><i class="fas fa-shopping-cart"></i> Historial de compras en ejecución</h6>
                <table class="table table-sm table-hover table-bordered small">
                    <thead class="text-center">
                    <tr class="table-secondary">
                        <th>Item</th>
                        <th>ID</th>
                        <th>Folio</th>
                        <th style="width: 7%">Fecha Creación</th>
                        <th>Tipo / Mecanismo de Compra</th>
                        <th>Descripción</th>
                        <th>Usuario Gestor</th>
                        <th>Comprador</th>
                        <th>Items</th>
                        <th>Monto total</th>
                        <th>Monto utilizado</th>
                        <!-- <th>Saldo disponible</th> -->
                        <!-- <th>Estado</th> -->
                        <!-- <th></th>  -->
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($purchasePlan->requestForms as $key => $child)
                        <tr @if($child->status->value != 'approved') class="text-muted" @endif>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $child->id }}<br>
                                @switch($child->status->getLabel())
                                    @case('Pendiente')
                                    <i class="fas fa-clock"></i>
                                    @break

                                    @case('Aprobado')
                                    <span style="color: green;">
            <i class="fas fa-check-circle" title="{{ $child->status->getLabel() }}"></i>
            </span>
                                    @break

                                    @case('Rechazado')
                                    <a href="">
            <span style="color: Tomato;">
                <i class="fas fa-times-circle" title="{{ $child->status->getLabel() }}"></i>
            </span>
                                    </a>
                                    @break

                                @endswitch
                            </td>
                            <td>@if($child->status->value == 'approved')
                                    <a href="{{ route('request_forms.show', $child) }}">{{ $child->folio }}</a>
                                @else
                                    {{ $child->folio }}
                                @endif<br>
                            <td>{{ $child->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ ($child->purchaseMechanism) ? $child->purchaseMechanism->PurchaseMechanismValue : '' }}
                                <br>
                                {{ $child->SubtypeValue }}
                            </td>
                            <td>{{ $child->name }}</td>
                            <td>{{ $child->user ? $child->user->fullName : 'Usuario eliminado' }}<br>
                                {{ $child->userOrganizationalUnit ? $child->userOrganizationalUnit->name : 'Usuario eliminado' }}
                            </td>
                            <td>{{ $child->purchasers->first()->fullName ?? 'No asignado' }}</td>
                            <td align="center">{{ $child->quantityOfItems() }}</td>
                            <td align="right">{{$child->symbol_currency}}{{ number_format($child->estimated_expense,$child->precision_currency,",",".") }}</td>
                            <td align="right">{{ $child->purchasingProcess ? $child->symbol_currency.number_format($child->purchasingProcess->getExpense(),$child->precision_currency,",",".") : '-' }}</td>
                            {{--<td align="right">{{ $child->purchasingProcess ? $child->symbol_currency.number_format($child->estimated_expense - $child->purchasingProcess->getExpense(),$child->precision_currency,",",".") : '-' }}</td>--}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">No existen bienes y/o servicios de ejecución
                                inmediata asociados a este formulario de requerimiento.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    
                        <tfoot>
                        <tr>
                            <th colspan="9" class="text-end">Totales
                            </th>
                            <th class="text-end">${{ number_format($purchasePlan->getTotalEstimatedExpense(),0,",",".") }}</th>
                            <th class="text-end">${{ number_format($purchasePlan->getTotalExpense(),0,",",".") }}</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-end">Saldo disponible Compras
                            </th>
                            <th class="text-end">${{ number_format($purchasePlan->estimated_expense - $child->getTotalExpense(),$child->precision_currency,",",".") }}</th>
                        </tr>
                        </tfoot>          
                </table>
            </div>
        </div>
    </div>
@endif

@endsection

@section('custom_js')

@endsection