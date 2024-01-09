@extends('layouts.bt4.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Todos los viáticos (Gestionados por: Dirección)</h5>

<br />
</div>

<div class="col-sm">
    @livewire('allowances.search-allowances', [
        'index' => 'director'
    ])
</div>

@endsection

@section('custom_js')

@endsection