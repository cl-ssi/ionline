@extends('layouts.app')

@section('title', ($type == 'receiving') ? 'Lista de Ingreso' : 'Listado de Egreso')

@section('content')

@include('warehouse.nav')

@livewire('warehouse.control.control-index', [
    'store' => $store,
    'type'  => $type
])

@endsection
