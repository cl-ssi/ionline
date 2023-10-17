@extends('layouts.bt4.app')

@section('title', 'Lista de Unidades Organizacionales')

@section('content')

<h3 class="mb-3">Unidades Organizacionales</h3>
<h4 class="mb-3">{{ auth()->user()->organizationalUnit->establishment->name }}</h4>

<fieldset class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Ingrese Nombre" name="search" required="">
        @cannot(['Service Request', 'Service Request: export sirh mantenedores'])
        <div class="input-group-append">
            <a class="btn btn-primary" href="{{ route('rrhh.organizational-units.create') }}"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
        @endcan
    </div>
</fieldset>



<div class="table-responsive">
    <table class="table table-striped table-sm" id="TableFilter">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Nombre</th>
                <th scope="col">Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ouTree as $id => $ou)
            <tr style="font-family:monospace;">
                <td></td>
                <td>{{ $ou }}</td>
                <td>
                    <a href="{{ route('rrhh.organizational-units.edit', $id) }}" 
                        class="btn btn-outline-secondary btn-sm">
                    <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
