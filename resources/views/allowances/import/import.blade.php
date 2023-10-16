@extends('layouts.bt4.app')

@section('title', 'Importar Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Carga de Viáticos desde archivo</h5>

<br>

@livewire('allowances.imports.import-allowances')


@endsection

@section('custom_js')

@endsection