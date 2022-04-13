@extends('layouts.app')

@section('title', 'Familias')

@section('content')

@include('pharmacies.nav')

@livewire('warehouse.family.family-index', ['segment' => $segment])

@endsection
