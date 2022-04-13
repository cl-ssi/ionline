@extends('layouts.app')

@section('title', 'Editar Segmento')

@section('content')

@include('pharmacies.nav')

@include('layouts.partials.flash_message')
@include('layouts.partials.errors')

@livewire('warehouse.segment.segment-edit', ['segment' => $segment])

@endsection
