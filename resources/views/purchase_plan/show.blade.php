@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-12">
        <h5 class="mb-3">
            <i class="fas fa-shopping-cart"></i> Plan de Compra: ID {{ $purchasePlan->id }}
            @switch($purchasePlan->status)
                @case('save')
                    <span class="badge bg-primary badge-sm">Guardado</span>
                    @break
            
                @case('sent')
                    <span class="badge bg-secondary badge-sm">Enviado</span>
                    @break
                @default
                    ''
            @endswitch
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
                <td class="text-left">{{ $purchasePlan->userResponsible->FullName }}</td>
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
                <td class="text-left">{{ $purchasePlan->organizationalUnit->name }}</td>
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
        </thead>
    </table>
</div>



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

<div class="row"> 
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
                <th width="" class="table-secondary" rowspan="2"></th>
            </tr>
            <tr>
                <th class="table-secondary">Solicitados</th>
                <th class="table-secondary">Programados</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchasePlan->purchasePlanItems as $item)
            <tr class="text-center">
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
                    {{--
                    <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                        class="btn btn-outline-secondary btn-sm"><i class="fas fa-calendar-alt"></i>
                    --}}
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-ppl-{{ $item->id }}">
                        <i class="fas fa-calendar-alt"></i>
                    </button>

                    @include('purchase_plan.modals.detail_month', [
                        'item' => $item
                    ])
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
                <th width="" class="table-secondary">{{ $approval->organizationalUnit->name }}</th>
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
                                <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                            </span>
                            @break
                    @endswitch
                    <br>
                    @if($approval->StatusInWords == 'Aprobado' || $approval->StatusInWords == 'Rechazado')
                        <i class="fas fa-user"></i> {{ ($approval->approver) ? $approval->approver->FullName : '' }} <br>
                        <i class="fas fa-calendar-alt"></i> {{ ($approval->approver_at) ? $approval->approver_at->format('d-m-Y H:i:s') : '' }}
                    @endif
                </td>           
                @endforeach
            </tr>
        <tbody>
    </table>
</div>
@else

<div class="alert alert-info" role="alert">
    Estimado Usuario: El Plan de Compras aún no ha sido enviado para aprobaciones.
</div>

@endif

@endsection

@section('custom_js')

@endsection