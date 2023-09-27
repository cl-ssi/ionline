@extends('layouts.app-bootstrap-5')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-12">
        <h5 class="mb-3">
            <i class="fas fa-shopping-cart"></i> Plan de Compra: ID {{ $purchasePlan->id }}
            @if($purchasePlan->status == "save")
                <span class="badge bg-primary badge-sm">Guardado</span>
            @endif
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
                <th width="30%" class="table-secondary">Funcionario Responsable</th>
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
                <td></td>
            </tr>
            <tr>
                <th class="table-secondary">Monto aprobado</th>
                <td></td>
            </tr>
        </thead>
    </table>
</div>

<div class="col"> 
    <a class="btn btn-primary btn-sm float-end"
        href="{{-- route('request_forms.edit', $requestForm) --}}">
        <i class="fas fa-edit"></i> Editar
    </a>
</div>

<br>

<h6><i class="fas fa-info-circle"></i> 2. Ítems a comprar</h6>
<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr class="text-center">
                <th width="" class="table-secondary">#</th>
                {{-- <th width="" class="table-secondary">Item</th> --}}
                <th width="" class="table-secondary">Artículo</th>
                <th width="" class="table-secondary">UM</th>
                <th width="" class="table-secondary">Especificaciones Técnicas</th>
                <th width="" class="table-secondary">Archivo</th>
                <th width="" class="table-secondary">Cantidad</th>
                <th width="" class="table-secondary">Valor U.</th>
                <th width="" class="table-secondary">Impuestos</th>
                <th width="" class="table-secondary">Total Item</th>
                <th width="" class="table-secondary"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchasePlan->purchasePlanItems as $item)
            <tr class="text-center">
                <td>{{ $item->id }}</td>
                <td>{{ $item->unspscProduct->name }}</td>
                <td>{{ $item->unit_of_measurement }}</td>
                <td>{{ $item->specification }}</td>
                <td></td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_value,2,",",".") }}</td>
                <td>{{ $item->tax }}</td>
                <td>${{ number_format($item->expense,2,",",".") }}</td>
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
    </table>
</div>

@endsection

@section('custom_js')

@endsection