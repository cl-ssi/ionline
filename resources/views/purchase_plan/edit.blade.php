@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-md">
        <h4 class="mb-3"><i class="fas fa-plus"></i> Plan de Compra: </h4>
        {{-- <p>Incluye Planes de Compras de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</p> --}}
    </div>
</div>

<br>

@livewire('purchase-plan.create-purchase-plan', [
    'action'                => 'edit',
    'purchasePlanToEdit'    => $purchasePlan
])

@endsection

@section('custom_js')

@endsection
