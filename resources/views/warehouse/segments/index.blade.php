@extends('layouts.app')

@section('title', 'Segmentos')

@section('content')

@include('pharmacies.nav')

@include('layouts.partials.flash_message')
@include('layouts.partials.errors')

@livewire('warehouse.segment.segment-index')

@endsection
