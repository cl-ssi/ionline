@extends('layouts.bt4.app')

@section('title', 'Crear Subrogante para La Unidad Organizacional')

@section('content')

<h3 class="mb-3">Asignar Usuario como Subrogante a la Unidad Organizacional {{$organizationalUnit->name }}</h3>
<form method="POST" class="form-horizontal" action="{{ route('rrhh.subrogations.store') }}">
    @csrf
    @method('POST')
    <input type="hidden" name="organizational_unit_id" value="{{$organizationalUnit->id}}">
    <div class="form-row mb-3">
        <fieldset class="col-12 col-md-6">
            <label for="for-name">Subrogante</label>
            @livewire('search-select-user')
        </fieldset>
        <fieldset class="col-6 col-md-3">
            <label for="for-type">Tipo</label>
            <select name="type" id="for_type_id" class="form-control" title="Seleccione tipo" required>
                <option value="">Seleccionar Tipo</option>
                <option value="manager">Encargado (Jefes)</option>
                <option value="delegate">Delegado (Igual acceso que el jefe)</option>
                <option value="secretary">Secretario/a</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-5 col-md-3">
            <label for="for_decree">Nivel (orden según decreto)</label>
            <input type="number" class="form-control" id="for_level" name="level" autocomplete="off">
        </fieldset>
    </div>
    <div class="form-row mb-3">
        <div class="col-12">
            <button type="submit" class="btn btn-primary float-left">Guardar</button>
            <a href="{{ route('rrhh.new-authorities.calendar',$organizationalUnit->id) }}" class="btn btn-secondary float-right">Cancelar</a>
        </div>
    </div>
</form>
<hr>
<h4>Actualmente los subrogantes de tipo Encargado (Jefes):</h4>
<div class="table-responsive">
    <table class="table bg-primary text-dark">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Nivel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subrogations->where('type', 'manager') as $subrogation)
            <tr>
                <td>{{ $subrogation->user->name }}</td>
                <td>{{ $subrogation->level }}</td>
            </tr>
            @endforeach
        </tbody>
</table>
</div>

<h4>Actualmente los subrogantes de tipo Delegado (Igual acceso que el jefe):</h4>
<div class="table-responsive">
    <table class="table bg-secondary text-dark">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Nivel</th>
                </tr>
        </thead>
        <tbody>
            @foreach($subrogations->where('type', 'delegate') as $subrogation)
            <tr>
                <td>{{ $subrogation->user->name }}</td>
                <td>{{ $subrogation->level }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h4>Actualmente los subrogantes de tipo Secretario/a:</h4>
<div class="table-responsive">
    <table class="table bg-warning text-dark">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Nivel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subrogations->where('type', 'secretary') as $subrogation)
            <tr>
                <td>{{ $subrogation->user->name }}</td>
                <td>{{ $subrogation->level }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection