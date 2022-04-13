@extends('layouts.app')

@section('title', 'Productos')

@section('content')

@include('pharmacies.nav')

@livewire('warehouse.product.product-index', ['segment' => $segment, 'family' => $family, 'class' => $class])

@endsection
