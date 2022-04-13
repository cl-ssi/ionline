@extends('layouts.app')

@section('title', 'Buscar Productos')

@section('content')

@include('pharmacies.nav')

@livewire('warehouse.product.product-all')

@endsection