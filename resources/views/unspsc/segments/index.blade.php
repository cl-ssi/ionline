@extends('layouts.app')

@section('title', 'Segmentos')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.segment.segment-index')

@endsection
