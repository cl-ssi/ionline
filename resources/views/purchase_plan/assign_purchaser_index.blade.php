@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-md">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Planes de Compras para asignar: </h4>
    </div>
</div>

</div>

<div class="container-fluid">
    @livewire('purchase-plan.search-purchase-plan', [
        'index'    => 'assign_purchaser',
    ])
</div>

@endsection

@section('custom_js')

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

@endsection
