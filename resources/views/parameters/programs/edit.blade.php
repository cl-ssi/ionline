@extends('layouts.app')

@section('title', 'Editar Programa')

@section('content')

@livewire('parameters.program.program-edit', [
    'program' => $program
])

@endsection
