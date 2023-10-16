@extends('layouts.bt4.app')

@section('title', 'Editar Destino')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.destinations.destination-edit', [
    'store' => $store,
    'destination' => $destination,
    'nav' => $nav,
])

@endsection
