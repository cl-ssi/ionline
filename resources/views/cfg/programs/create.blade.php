@extends('layouts.app')

@section('title', 'Crear Programa')

@section('content')

@include('parameters.nav')

@livewire('cfg.program.program-create')

@endsection
