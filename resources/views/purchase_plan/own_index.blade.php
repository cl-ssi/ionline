@extends('layouts.app-bootstrap-5')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-md">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Mis Planes de Compras: </h4>
        <p>Incluye Planes de Compras de mi Unidad Organizacional: <b>{{ Auth()->user()->organizationalUnit->name }}</p>
    </div>
</div>

<br>

@livewire('purchase-plan.search-purchase-plan', [
    'index'    => 'own',
])

@endsection

@section('custom_js')

@endsection
