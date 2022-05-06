@extends('layouts.app')

@section('title', 'Productos')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.product.product-index', [
    'segment' => $segment,
    'family' => $family,
    'class' => $class
])

@endsection
