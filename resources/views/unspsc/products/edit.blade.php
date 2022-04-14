@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.product.product-edit', [
    'segment' => $segment,
    'family' => $family,
    'class' => $class,
    'product' => $product
])

@endsection
