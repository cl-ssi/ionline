@extends('layouts.app')

@section('title', 'Revisar Producto ' . $control->type_format)

@section('content')

@include('warehouse.nav')

<h4>{{ $control->type_format }} {{ $control->id }}</h4>

@livewire('warehouse.control.control-details', [
    'control' => $control
])

@livewire('warehouse.control.control-review-product', [
    'store' => $store,
    'control' => $control,
])

@endsection
