@extends('layouts.app')

@section('title', 'Editar Familia')

@section('content')

@include('pharmacies.nav')

@livewire('warehouse.family.family-edit', [
    'segment' => $segment,
    'family' => $family
])

@endsection
