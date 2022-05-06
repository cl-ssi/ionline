@extends('layouts.app')

@section('title', 'Editar Clase')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.clase.clase-edit', [
    'segment' => $segment,
    'family' => $family,
    'class' => $class
])

@endsection
