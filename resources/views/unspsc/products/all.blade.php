@extends('layouts.app')

@section('title', 'Buscar Productos')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.product.product-all')

@endsection