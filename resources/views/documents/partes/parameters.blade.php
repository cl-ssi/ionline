@extends('layouts.bt4.app')

@section('title', 'Bandeja de salida')

@section('content')

@include('documents.partes.partials.nav')


<h3 class="mb-3">Parametros Unidad de Partes</h3>


@livewire('parameters.parameter.single-manager',[
    'module' => 'partes',
    'parameterName' => 'Usuario Numeración Automático',
    'type' => 'user',
    'establishment_id' => auth()->user()->establishment_id,
    'parameterDescription' => 'ingresar el RUN sin dv de la persona que generara el numero de parte de manera automática en el módulo recepción'
])


@endsection