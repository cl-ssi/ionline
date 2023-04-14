@extends('layouts.app')

@section('title', 'Carga de archivos amiPASS')

@section('content')

@include('welfare.nav')

@livewire('welfare.amipass-contract-import')

<hr>

@livewire('welfare.amipass-abscences-import')

@endsection