@extends('layouts.bt4.app')

@section('title', 'Editar Origen')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.origins.origin-edit', [
    'store' => $store,
    'origin' => $origin,
    'nav' => $nav,
])

@endsection
