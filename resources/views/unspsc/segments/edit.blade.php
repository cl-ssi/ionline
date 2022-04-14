@extends('layouts.app')

@section('title', 'Editar Segmento')

@section('content')

@include('pharmacies.nav')

@livewire('unspsc.segment.segment-edit', ['segment' => $segment])

@endsection
