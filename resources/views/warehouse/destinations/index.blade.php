@extends('layouts.bt4.app')

@section('title', 'Destinos')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.destinations.destination-index', [
    'store' => $store,
    'nav' => $nav,
])

@endsection
