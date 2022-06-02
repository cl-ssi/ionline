@extends('layouts.app')

@section('title', 'Crear Programa')

@section('content')

@include('parameters.nav')

@livewire('parameters.program.program-create')

@endsection
