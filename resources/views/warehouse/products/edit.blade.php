@extends('layouts.bt4.app')

@section('title', 'Editar Producto')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.products.product-edit', [
    'store' => $store,
    'product' => $product,
    'nav' => $nav,
])

@endsection
