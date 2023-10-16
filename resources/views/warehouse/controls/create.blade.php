@extends('layouts.bt4.app')

@section('title', ($type == 'receiving') ? 'Crear Ingreso' : 'Crear Egreso')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.control.control-create', [
    'store' => $store,
    'type' => $type,
    'nav' => $nav,
])

@endsection
