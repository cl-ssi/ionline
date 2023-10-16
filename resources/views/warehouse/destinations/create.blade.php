@extends('layouts.bt4.app')

@section('title', 'Crear Destino')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.destinations.destination-create', [
    'store' => $store,
    'nav' => $nav,
])

@endsection
