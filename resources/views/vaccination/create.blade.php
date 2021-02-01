@extends('layouts.app')

@section('title', 'Crear nuevo funcionario')

@section('content')

@include('vaccination.partials.nav')

<h3 class="mb-3">Crear nuevo funcionario</h3>

<form method="POST" class="form-horizontal" action="{{ route('vaccination.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col-md-3 col-12">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" name="name"
                id="for_name" required>
        </fieldset>

        <fieldset class="form-group col-md-2 col-12">
            <label for="for_fathers_family">Apellido Paterno*</label>
            <input type="text" class="form-control" name="fathers_family"
                id="for_fathers_family" required>
        </fieldset>

        <fieldset class="form-group col-md-2 col-12">
            <label for="for_mothers_family">Apellido Materno*</label>
            <input type="text" class="form-control" name="mothers_family"
                id="for_mothers_family" required>
        </fieldset>

        <fieldset class="form-group col-md-2 col-9">
            <label for="for_run">Run*</label>
            <input type="text" class="form-control" name="run"
                id="for_run" required placeholder="sin digito">
        </fieldset>

        <fieldset class="form-group col-md-1 col-3">
            <label for="for_dv">Digito*</label>
            <input type="text" class="form-control" name="dv"
                id="for_dv" required>
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-3 col-12">
            <label for="for_establishment">Establecimiento*</label>
            <select name="establishment_id" id="for_establishment" class="form-control">
                <option value=""></option>
                <option value="1">HETG</option>
                <option value="38">DSSI</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-md-4 col-12">
            <label for="for_ortanizationalUnit">Unidad Organizacional</label>
            <input type="text" class="form-control" name="ortanizationalUnit"
                id="for_ortanizationalUnit" placeholder="unidad/depto">
        </fieldset>

        <fieldset class="form-group col-md-3 col-12">
            <label for="for_inform_method">Informado a través</label>
            <select name="inform_method" id="for_inform_method" class="form-control">
                <option value=""></option>
                <option value="1">Teléfono</option>
            </select>
        </fieldset>


        {{-- <fieldset class="form-group col-md-3 col-12">
            <label for="for_organizational_unit_id">Unidad Organizacional</label>
            <select name="organizational_unit_id" id="for_organizational_unit_id" class="form-control">
                <option value=""></option>
            </select>
        </fieldset> --}}
    </div>

    <div class="row">
        <fieldset class="form-group col-md-3 col-12">
            <label for="for_first_dose">Agenda Primera dósis</label>
            <input type="datetime-local" class="form-control" name="first_dose"
                id="for_first_dose">
        </fieldset>

        <fieldset class="form-group col-md-3 col-12">
            <label for="for_second_dose">Agenda Segunda dósis</label>
            <input type="datetime-local" class="form-control" name="second_dose"
                id="for_second_dose">
        </fieldset>

    </div>

    <hr>

    <div class="row">
        <fieldset class="form-group col-md-3 col-12">
            <label for="for_first_dose_at">Primera dosis</label>
            <input type="datetime-local" class="form-control" name="first_dose_at"
                id="for_first_dose_at">
        </fieldset>

        <fieldset class="form-group col-md-9 col-12">
            <label for="for_fd_observation">Observación</label>
            <input type="text" class="form-control" name="fd_observation"
                id="for_fd_observation">
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col-md-3 col-12">
            <label for="for_second_dose_at">Segunda dosis</label>
            <input type="datetime-local" class="form-control" name="second_dose_at"
                id="for_second_dose_at">
        </fieldset>

        <fieldset class="form-group col-md-9 col-12">
            <label for="for_sd_observation">Observacion</label>
            <input type="text" class="form-control" name="sd_observation"
                id="for_sd_observation">
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary form-control">Crear</button>


</form>

@endsection

@section('custom_js')

@endsection
