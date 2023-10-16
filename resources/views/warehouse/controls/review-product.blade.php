@extends('layouts.bt4.app')

@section('title', 'Revisar Producto ' . $control->type_format)

@section('content')

@include('warehouse.' . $nav)

<h4>{{ $control->type_format }} {{ $control->id }}: {{ $store->name }}</h4>

@include('warehouse.controls.details', [
    'control' => $control
])

<hr>

@livewire('warehouse.control.control-review-product', [
    'store' => $store,
    'control' => $control,
    'nav' => $nav,
])

@endsection
