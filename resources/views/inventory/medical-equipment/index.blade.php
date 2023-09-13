@extends('layouts.app')

@section('title', 'Lista de Equipo Medico')

@section('content')

    <div class="row">
        <div class="col">
            <h3 class="mb-3">Equipo Medico</h3>
        </div>
        <div class="col-md-4 text-right">
            <a class="btn btn-primary mx-1" href="{{ route('medical-equipment.create') }}">
                <i class="fas fa-plus"></i> Agregar nuevo
            </a>

            <a class="btn btn-success float-right" href="{{ route('medical-equipment.export') }}">
                <i class="fas fa-file-excel"></i> Exportar Listado
            </a>
        </div>
    </div>

    @livewire('inventory.medical-equipment.medical-equipment-index')

@endsection
