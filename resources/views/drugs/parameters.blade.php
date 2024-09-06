@extends('layouts.bt5.app')

@section('title', 'Parametros Unidad de Drogas')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Parametros Unidad de Drogas</h3>

@livewire('parameters.parameter.single-manager',[
    'module' => 'drugs',
    'parameter' => 'Jefe',
    'type' => 'user'
], key('Jefe'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameter' => 'CargoJefe',
    'type' => 'value'
], key('CargoJefe'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameter'=>'MinistroDeFe',
    'type' => 'user'
], key('MinistroDeFe'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameter'=>'MinistroDeFeJuridico',
    'type' => 'user'
], key('MinistroDeFeJuridico'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameter'=>'Mandatado',
    'type' => 'user'
], key('Mandatado'))

@livewire('parameters.parameter.single-manager',[
    'module'=>'drugs',
    'parameter'=>'MandatadoResolucion',
    'type' => 'value'
], key('MandatadoResolucion'))


@endsection
