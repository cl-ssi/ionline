@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

<div class="alert alert-info alert-sm" role="alert">
    <div class="row">
        <div class="col-sm">
            <i class="fas fa-info-circle"></i> <b>Fecha límite para la emisión de formularios de requerimientos para nuevos procesos de compra</b>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 text-justify">
            <br />
            Todos los formularios de requerimientos para nuevos procesos de compra deberán emitirse a más 
            tardar el <b>30 de septiembre de 2024</b>. Es importante destacar que los formularios de requerimientos 
            de suministro mensual no están sujetos a esta fecha límite, de igual que los formularios de requerimientos 
            de presupuestos de programas o proyectos asignados posterior al 30-09-2024.
        </div>
        <div class="col-sm-4">
            <br />
            <a class="btn btn-light btn-sm float-right" href="{{ route('request_forms.circular_3650_2024') }}"
                target="blank">
                <i class="far fa-file-pdf"></i> Descargar circular aquí
            </a>
        </div>
    </div>
</div>

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-md">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Mis Planes de Compras: </h4>
        <p>Incluye Planes de Compras de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }} ({{ auth()->user()->organizationalUnit->establishment->name}})</b></p>
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
