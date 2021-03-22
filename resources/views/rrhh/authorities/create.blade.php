@extends('layouts.app')

@section('title', 'Agregar Autoridad')

@section('content')
<h3 class="mb-3">Agregar Autoridad del {{ $ouTopLevel->establishment->name }}</h3>

@can('Authorities: manager')
<form method="POST" class="form-horizontal" action="{{ route('rrhh.authorities.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_organizational_unit_id">Unidad Organizacional</label>
            <select name="organizational_unit_id" id="for_organizational_unit_id" class="form-control" style="font-family:monospace; font-size: 15px;">
                <option value="{{ $ouTopLevel->id }}">{{ $ouTopLevel->name }}</option>
                @foreach($ouTopLevel->childs as $child_level_1)
                    <option value="{{ $child_level_1->id }}"> - {{ $child_level_1->name }}</option>
                        @foreach($child_level_1->childs as $child_level_2)
                            <option value="{{ $child_level_2->id }}"> - - {{ $child_level_2->name }}</option>
                                @foreach($child_level_2->childs as $child_level_3)
                                    <option value="{{ $child_level_3->id }}"> - - - {{ $child_level_3->name }}</option>
                                @endforeach
                        @endforeach
                @endforeach

            </select>
        </fieldset>
    </div>

    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_user_id">Funcionario</label>
            <select name="user_id" id="for_user_id" class="form-control">
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->fullName }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_from">Desde</label>
            <input type="date" class="form-control" id="for_from" name="from" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_to">Hasta</label>
            <input type="date" class="form-control" id="for_to" name="to" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_position">Cargo</label>
            <select name="position" id="for_position" class="form-control" required>
                <option value=""></option>
                <option>Director</option>
                <option>Directora</option>
                <option>Director (S)</option>
                <option>Directora (S)</option>
                <option>Subdirector</option>
                <option>Subdirectora</option>
                <option>Subdirector (S)</option>
                <option>Subdirectora (S)</option>
                <option>Jefe</option>
                <option>Jefa</option>
                <option>Jefe (S)</option>
                <option>Jefa (S)</option>
                <option>Encargado</option>
                <option>Encargada</option>
                <option>Encargado (S)</option>
                <option>Encargada (S)</option>
                <option>Secretario</option>
                <option>Secretaria</option>
                <option>Secretario (S)</option>
                <option>Secretaria (S)</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_type">Tipo</label>
            <select name="type" id="for_type" class="form-control">
                <option value="manager">Encargado (Jefes)</option>
                <option value="delegate">Delegado (Igual acceso que el jefe)</option>
                <option value="secretary">Secretario/a</option>
            </select>
        </fieldset>


    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('rrhh.authorities.index') }}" class="btn btn-outline-dark">Cancelar</a>

</form>

@endcan

@endsection

@section('custom_js')

@endsection
