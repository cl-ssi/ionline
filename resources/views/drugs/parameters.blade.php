@extends('layouts.app')

@section('title', 'Parametros Unidad de Drogas')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Parametros Unidad de Drogas</h3>

@livewire('parameters.parameter.single-manager',[
    'module' => 'drugs',
    'parameterName' => 'Jefe',
    'type' => 'user'
])

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName' => 'CargoJefe',
    'type' => 'value'
])

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName'=>'MinistroDeFe',
    'type' => 'user'
])

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName'=>'MinistroDeFeJuridico',
    'type' => 'user'
])

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName'=>'Mandatado',
    'type' => 'user'
])

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName'=>'MandatadoResolucion',
    'type' => 'value'
])


@endsection
