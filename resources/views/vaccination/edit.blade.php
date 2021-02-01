@extends('layouts.app')

@section('title', 'Crear nuevo funcionario')

@section('content')

@include('vaccination.partials.nav')

<h3 class="mb-3">Editar funcionario</h3>

<form method="POST" class="form-horizontal" action="{{ route('vaccination.update',$vaccination) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
        <fieldset class="form-group col-md-3 col-12">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" name="name"
                id="for_name" required value="{{ $vaccination->name }}">
        </fieldset>

        <fieldset class="form-group col-md-2 col-12">
            <label for="for_fathers_family">Apellido Paterno*</label>
            <input type="text" class="form-control" name="fathers_family"
                id="for_fathers_family" required value="{{ $vaccination->fathers_family }}">
        </fieldset>

        <fieldset class="form-group col-md-2 col-12">
            <label for="for_mothers_family">Apellido Materno*</label>
            <input type="text" class="form-control" name="mothers_family"
                id="for_mothers_family" required value="{{ $vaccination->mothers_family }}">
        </fieldset>

        <fieldset class="form-group col-md-2 col-9">
            <label for="for_run">Run*</label>
            <input type="text" class="form-control" name="run"
                id="for_run" required value="{{ $vaccination->run }}">
        </fieldset>

        <fieldset class="form-group col-md-1 col-3">
            <label for="for_dv">Digito*</label>
            <input type="text" class="form-control" name="dv"
                id="for_dv" required value="{{ $vaccination->dv }}">
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-3 col-12">
            <label for="for_establishment">Establecimiento*</label>
            <select name="establishment_id" id="for_establishment" class="form-control">
                <option value=""></option>
                <option value="1" {{ ($vaccination->establishment_id == 1)? 'selected':'' }}>HETG</option>
                <option value="38" {{ ($vaccination->establishment_id == 38)? 'selected':'' }}>DSSI</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-md-4 col-12">
            <label for="for_ortanizationalUnit">Unidad Organizacional</label>
            <input type="text" class="form-control" name="ortanizationalUnit"
                id="for_ortanizationalUnit" placeholder="unidad/depto" value="{{ $vaccination->organizationalUnit }}">
        </fieldset>

        <fieldset class="form-group col-md-3 col-12">
            <label for="for_inform_method">Informado a través</label>
            <select name="inform_method" id="for_inform_method" class="form-control">
                <option value=""></option>
                <option value="1" {{ ($vaccination->inform_method == 1)? 'selected':'' }}>Clave Única</option>
                <option value="2" {{ ($vaccination->inform_method == 2)? 'selected':'' }}>Teléfono</option>
            </select>
        </fieldset>

        {{-- <fieldset class="form-group col-3">
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
                id="for_first_dose" required value="{{ optional($vaccination->first_dose)->format('Y-m-d\TH:i:s') }}">
        </fieldset>

        <fieldset class="form-group col-md-3 col-12">
            <label for="for_second_dose">Agenda Segunda dósis</label>
            <input type="datetime-local" class="form-control" name="second_dose"
                id="for_second_dose" value="{{ optional($vaccination->second_dose)->format('Y-m-d\TH:i:s') }}">
        </fieldset>

    </div>

    <hr>

    <div class="row">
        <fieldset class="form-group col-md-3 col-12">
            <label for="for_first_dose_at">Primera dosis</label>
            <input type="datetime-local" class="form-control" name="first_dose_at"
                id="for_first_dose_at" value="{{ optional($vaccination->first_dose_at)->format('Y-m-d\TH:i:s') }}">
        </fieldset>

        <fieldset class="form-group col-md-9 col-12">
            <label for="for_fd_observation">Observación</label>
            <input type="text" class="form-control" name="fd_observation"
                id="for_fd_observation" value="{{ $vaccination->fd_observation }}">
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col-md-3 col-12">
            <label for="for_second_dose_at">Segunda dosis</label>
            <input type="datetime-local" class="form-control" name="second_dose_at"
                id="for_second_dose_at" value="{{ optional($vaccination->second_dose_at)->format('Y-m-d\TH:i:s') }}">
        </fieldset>

        <fieldset class="form-group col-md-9 col-12">
            <label for="for_sd_observation">Observacion</label>
            <input type="text" class="form-control" name="sd_observation"
                id="for_sd_observation" value="{{ $vaccination->sd_observation }}">
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary form-control">Actualizar</button>


</form>

@can('be god')
    @include('partials.audit', ['audits' => $vaccination->audits] )
@endcan

@endsection

@section('custom_js')

@endsection
