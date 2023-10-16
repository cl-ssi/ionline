@extends('layouts.bt4.app')

@section('title', 'Agregar Autoridad')

@section('content')
<h3 class="mb-3">Agregar Autoridad del {{ $ouTopLevel->establishment->name }}</h3>

@can('Authorities: create')
<form method="POST" class="form-horizontal" action="{{ route('rrhh.authorities.store') }}">
    @csrf
    
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_organizational_unit_id">Unidad Organizacional*</label>
            @livewire('select-organizational-unit', [
                'establishment_id' => $ouTopLevel->establishment->id, 
                'organizational_unit_id' => $ou
            ])
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label for="for_user_id">Funcionario*</label>
            @livewire('search-select-user', ['required' => 'required']) 
        </fieldset>

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_user_id">En representación de (opcional)</label>
            @livewire('search-select-user', ['selected_id' => 'representation_id'])
        </fieldset>

    </div>
    <div class="form-row">
        <fieldset class="form-group col-6 col-md-3">
            <label for="for_from">Desde*</label>
            <input type="date" class="form-control" id="for_from" name="from" required>
        </fieldset>

        <fieldset class="form-group col-6 col-md-3">
            <label for="for_to">Hasta*</label>
            <input type="date" class="form-control" id="for_to" name="to" required>
        </fieldset>

        <fieldset class="form-group col-6 col-md-3">
            <label for="for_position">Cargo*</label>
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

        <fieldset class="form-group col-6 col-md-3">
            <label for="for_type">Tipo*</label>
            <select name="type" id="for_type" class="form-control" required>
                <option value="manager">Encargado (Jefes)</option>
                <option value="delegate">Delegado (Igual acceso que el jefe)</option>
                <option value="secretary">Secretario/a</option>
            </select>
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-12">
            <label for="for_decree">Decreto autorización del cargo</label>
            <input type="text" class="form-control" id="for_decree" name="decree">
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('rrhh.authorities.index') }}" class="btn btn-outline-dark">Cancelar</a>

</form>

@endcan

@endsection

@section('custom_js')

@endsection
