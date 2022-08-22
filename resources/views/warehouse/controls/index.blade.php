@extends('layouts.app')

@section('title', ($type == 'receiving') ? 'Lista de Ingresos' : 'Listado de Egresos')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.control.control-index', [
    'store' => $store,
    'type'  => $type,
    'nav'   => $nav,
])

@endsection
