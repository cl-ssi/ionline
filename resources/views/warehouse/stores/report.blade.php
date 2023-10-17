@extends('layouts.bt4.app')

@section('title', 'Reporte Bincard')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.control.control-report', [
    'store' => $store,
])

@endsection
