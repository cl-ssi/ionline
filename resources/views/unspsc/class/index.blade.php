@extends('layouts.app')

@section('title', 'Clases')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.clase.clase-index', [
    'segment' => $segment,
    'family' => $family
])

@endsection
