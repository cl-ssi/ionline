@extends('layouts.app')

@section('title', 'Farmacia')

@section('content')

@include('pharmacies.nav')

<h3 class="mb-3">Bienvenido al módulo de {{Auth::user()->pharmacies->first()->name}}</h3>
<h4>Bodega selecionada: {{Auth::user()->pharmacies->first()->name}}</h4>

@endsection

@section('custom_js')

@endsection
