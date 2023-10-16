@extends('layouts.bt4.app')

@section('title', 'Editar Producto')

@section('content')

@livewire('unspsc.product.product-edit', [
    'segment' => $segment,
    'family' => $family,
    'class' => $class,
    'product' => $product
])

@endsection
