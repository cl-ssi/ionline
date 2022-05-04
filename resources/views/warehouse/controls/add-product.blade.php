@extends('layouts.app')

@section('title', 'Agregar Producto')

@section('content')

@include('warehouse.nav')

<h4>
    @if($control->type)
        Nuevo Ingreso
    @else
        Nuevo Egreso
    @endif
</h4>

@livewire('warehouse.control.control-details', [
    'control' => $control
])

<hr>
<h4 class="my-2">Agregar Producto</h4>

@if($control->type)
    @livewire('warehouse.control.control-receiving-add-product', [
        'store' => $store,
        'control' => $control,

    ])
@else
    @livewire('warehouse.control.control-dispatch-add-product', [
        'store' => $store,
        'control' => $control
    ])
@endif

<hr>
<h4>Productos agregados</h4>

@livewire('warehouse.control.control-product-list', [
    'control' => $control
])

@endsection
