@extends('layouts.app')

@section('title', 'Programas')

@section('content')

@include('parameters.nav')

@livewire('parameters.program.program-index')

@endsection
