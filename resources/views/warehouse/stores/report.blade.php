@extends('layouts.app')

@section('title', 'Reporte')

@section('content')

@include('warehouse.nav')

@livewire('warehouse.control.control-report', [
    'store' => $store,
])

@endsection
