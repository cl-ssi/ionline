@extends('layouts.bt5.app')

@section('title', 'Parametro Partes')

@section('content')

@include('documents.partes.partials.nav')


<h3 class="mb-3">Parametros Unidad de Partes</h3>


@livewire('parameters.parameter.single-manager',[
    'module' => 'partes',
    'parameter' => 'numerador',
    'type' => 'user',
    'description' => 'ingresar el RUN sin dv de la persona que generara el numero de parte de manera automática en el módulo recepción'
])


@endsection