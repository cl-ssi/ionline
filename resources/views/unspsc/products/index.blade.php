@extends('layouts.app')

@section('title', 'Productos')

@section('content')

@livewire('unspsc.product.product-index', [
    'segment' => $segment,
    'family' => $family,
    'class' => $class
])

@endsection
