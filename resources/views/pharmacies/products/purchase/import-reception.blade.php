@extends('layouts.bt5.app')

@section('title', 'Importar recepciones')

@section('content')

@include('pharmacies.nav')

    <h3>Importar recepciones</h3>

    @livewire('pharmacies.import-reception')

@endsection

@section('custom_js')

@endsection
