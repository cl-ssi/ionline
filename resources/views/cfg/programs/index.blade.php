@extends('layouts.app')

@section('title', 'Programas')

@section('content')

@include('parameters.nav')

@livewire('cfg.program.program-index')

@endsection
