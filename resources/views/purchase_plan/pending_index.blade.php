@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-md">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Planes de Compras pendientes de firmar: </h4>
    </div>
</div>

@livewire('purchase-plan.search-purchase-plan', [
    'index'    => 'pending',
])

@endsection

@section('custom_js')

@endsection
