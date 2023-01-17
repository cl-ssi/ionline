@extends('layouts.app')

@section('title', 'Administrar Facturas')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.invoices.invoice-management', [
    'store' => $store
])

@endsection
