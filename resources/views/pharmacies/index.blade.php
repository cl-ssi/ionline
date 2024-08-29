@extends('layouts.bt4.app')

@section('title', 'Farmacia')

@section('content')

@include('pharmacies.nav')

<h3 class="mb-3">Bienvenido al módulo de bodegas</h3>
@if(auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id')))
    <h4>Bodega selecionada: {{auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id'))->name}}</h4>
@else
    <h4>Problema al cargar información. Ingrese nuevamente al módulo.</h4>
@endif

@endsection

@section('custom_js')

@endsection
