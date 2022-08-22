@extends('layouts.app')

@section('title', 'Productos')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.products.product-index', [
    'store' => $store,
    'nav' => $nav,
])

@endsection
