@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-md">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Mis Planes de Compras: </h4>
        <p>Incluye Planes de Compras de mi Unidad Organizacional: <b>{{ Auth()->user()->organizationalUnit->name }}</b></p>
    </div>
</div>

@livewire('purchase-plan.search-purchase-plan', [
    'index'    => 'own',
])

@endsection

@section('custom_js')

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

@endsection
