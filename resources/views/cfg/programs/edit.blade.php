@extends('layouts.app')

@section('title', 'Editar Programa')

@section('content')

@include('parameters.nav')

@livewire('cfg.program.program-edit', [
    'program' => $program
])

@endsection
