@extends('layouts.app')

@section('title', 'Parametros')

@section('content')

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('his.new-modification') }}" 
            href="{{ route('his.new-modification') }}">
            <i class="fas fa-plus"></i> Nueva solicitud</a>
    </li>    
    <li class="nav-item">
        <a class="nav-link {{ active('his.modification-mgr') }}" 
            href="{{ route('his.modification-mgr') }}">
            <i class="fas fa-list"></i> Listado de solicitudes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('his.parameters') }}" 
            href="{{ route('his.parameters') }}">
            <i class="fas fa-cog"></i> Parametros</a>
    </li>
</ul>

<h3 class="mb-3">Parametros</h3>



@livewire('parameters.parameter.single-manager',[
    'module'=>'his_modifications',
    'parameterName' => 'tipos_de_solicitudes',
    'type' => 'value'
])

<label for="for-unidades">Ids de las unidades que vendrán después de la jefatura de la persona que hizo la solicitud</label>
@livewire('parameters.parameter.single-manager',[
    'module'=>'his_modifications',
    'parameterName' => 'ids_unidades_vb',
    'type' => 'value'
])

<h5>Pendiente de desarrollar:</h5>
<ol>
    <li>Crear modelo para arhivos, una solicitud puede tener n archivos</li>
    <li>Habilitar la subida de archivos al crear la solicitud</li>
    <li>En el mgr (manager) listar los archivos asociados a la solicitud</li>
</ol>

@endsection