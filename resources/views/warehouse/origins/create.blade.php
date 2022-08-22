@extends('layouts.app')

@section('title', 'Crear Origen')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.origins.origin-create', [
    'store' => $store,
    'nav' => $nav,
])

@endsection
