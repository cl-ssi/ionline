@extends('layouts.app')

@section('title', 'Editar Product')

@section('content')

@include('pharmacies.nav')

@livewire('warehouse.product.product-edit', [
    'segment' => $segment,
    'family' => $family,
    'class' => $class,
    'product' => $product
])

@endsection
