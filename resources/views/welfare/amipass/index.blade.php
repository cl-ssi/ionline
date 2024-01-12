@extends('layouts.bt4.app')

@section('title', 'Carga de archivos amiPASS')

@section('content')

@include('welfare.nav')

@livewire('rrhh.contract-import')

<hr>

@livewire('rrhh.abscences-import')

<hr>

@livewire('rrhh.compensatory-days-import')

<hr>

@livewire('rrhh.ami-loads-import')

@endsection