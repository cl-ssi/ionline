@extends('layouts.bt5.app')

@section('title', 'Lista de Unidades Organizacionales')

@section('content')

<h3 class="mb-3">Unidades Organizacionales</h3>
<h4 class="mb-3">{{ auth()->user()->organizationalUnit->establishment->name }}</h4>

<fieldset class="mb-3">
    <form action="{{ route('rrhh.organizational-units.index') }}" method="GET">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" id="forsearch" placeholder="Ingrese Nombre" name="search" value="{{ request('search') }}" autocomplete="off">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </div>
    </form>
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
