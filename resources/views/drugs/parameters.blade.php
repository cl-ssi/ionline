@extends('layouts.bt4.app')

@section('title', 'Parametros Unidad de Drogas')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Parametros Unidad de Drogas</h3>

@livewire('parameters.parameter.single-manager',[
    'module' => 'drugs',
    'parameterName' => 'Jefe',
    'type' => 'user'
], key('Jefe'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName' => 'CargoJefe',
    'type' => 'value'
], key('Jefe'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName'=>'MinistroDeFe',
    'type' => 'user'
], key('MinistroDeFe'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName'=>'MinistroDeFeJuridico',
    'type' => 'user'
], key('MinistroDeFeJuridico'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName'=>'Mandatado',
    'type' => 'user'
], key('Mandatado'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameterName'=>'MandatadoResolucion',
    'type' => 'value'
], key('MandatadoResolucion'))


@endsection
