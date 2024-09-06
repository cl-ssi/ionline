@extends('layouts.bt4.app')

@section('title', 'Parametros')

@section('content')

@include('his.partials.nav')

<h3 class="mb-3">Parametros</h3>


@livewire('parameters.parameter.single-manager',[
    'module'=>'his_modifications',
    'parameter' => 'tipos_de_solicitudes',
    'type' => 'value'
])

<label for="for-unidades">Ids de las unidades que van a dar VB</label>
@livewire('parameters.parameter.single-manager',[
    'module'=>'his_modifications',
    'parameter' => 'ids_unidades_vb',
    'type' => 'value'
])

<h5>Pendiente de desarrollar:</h5>
<ol>
    <li>Permitir subir archivos, una solicitud puede tener n archivos</li>
</ol>

@endsection