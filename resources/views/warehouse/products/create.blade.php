@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.products.product-create', [
    'store' => $store,
    'nav' => $nav,
])

@endsection
