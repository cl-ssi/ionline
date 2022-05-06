@extends('layouts.app')

@section('title', 'Familias')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.family.family-index', ['segment' => $segment])

@endsection
