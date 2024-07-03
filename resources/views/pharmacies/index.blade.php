@extends('layouts.bt4.app')

@section('title', 'Farmacia')

@section('content')

@include('pharmacies.nav')

<h3 class="mb-3">Bienvenido al módulo de bodegas</h3>
<h4>Bodega selecionada: {{auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id'))->name}}</h4>
-

@endsection

@section('custom_js')

@endsection
