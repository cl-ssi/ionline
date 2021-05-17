@extends('layouts.app')

@section('content')

@include('suitability.nav')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('suitability.users.create') }}">
            Agregar Usuario Externo
        </a>
    </div>
</div>


<h3 class="mb-3">Asignar Usuario Administrador a Colegio</h3>


<form method="POST" class="form-horizontal" action="{{ route('suitability.users.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_school_id">Colegios</label>
            <select name="school_id" id="for_school_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Colegio" required>
                <option value="">Seleccionar Colegio</option>
                @foreach($schools as $school)
                <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_user_id">Usuarios Externos</label>
            <select name="user_external_id" id="for_user_external_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Usuario" required>
                <option value="">Seleccionar Usuario</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                @endforeach
            </select>
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

<hr>

<h3 class="mb-3">Listado de Usuarios Administradores de Colegio</h3>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Contador</th>
            <th>Usuario</th>
            <th>Colegio</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>

        @foreach($schoolusers as $key => $schooluser)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $schooluser->user->fullname??'' }}</td>
            <td>{{ $schooluser->school->name??'' }}</td>
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('suitability.users.destroy', $schooluser->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea eliminar a {{ $schooluser->user->fullname }} como administrador de idoneidad del colegio {{ $schooluser->school->name }}? ' )"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>



@endsection

@section('custom_js')

@endsection