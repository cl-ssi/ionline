@extends('layouts.bt4.app')

@section('title', ($type == 'receiving') ? 'Lista de Ingresos' : 'Listado de Egresos')

@section('content')

@include('warehouse.' . $nav)

@if($type == 'receiving')
    @livewire('warehouse.control.control-receiving', [
        'store' => $store,
        'type'  => $type,
        'nav'   => $nav,
    ])
@endif

@if($type == 'dispatch')
    @livewire('warehouse.control.control-dispatch', [
        'store' => $store,
        'type'  => $type,
        'nav'   => $nav,
    ])
@endif

@endsection
