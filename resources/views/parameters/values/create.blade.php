@extends('layouts.app')

@section('title', 'Valor Hora/Jornada')

@section('content')

@include('parameters/nav')
<h3 class="mb-3">Crear nuevo valor Hora/Jornada</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.values.store') }}">
    @csrf
    @method('POST')

    <div class="row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_contract_type" >Tipo de Contrato*</label>
            <select name="contract_type" class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="Mensual">Mensual</option>
                <option value="Horas">Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_type" >Tipo</label>
            <select name="type" class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="Covid">Honorarios - Covid</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_guard_name">Jornada</label>
            <select id="for_work_type" name="work_type"  class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="DIURNO"  >DIURNO</option>
                <option value="TERCER TURNO">TERCER TURNO</option>
                <option value="TERCER TURNO - MODIFICADO">TERCER TURNO - MODIFICADO</option>
                <option value="CUARTO TURNO">CUARTO TURNO</option>
                <option value="CUARTO TURNO - MODIFICADO">CUARTO TURNO - MODIFICADO</option>
                <option value="HORA MÉDICA">HORA MÉDICA</option>
                <option value="DIURNO PASADO A TURNO">DIURNO PASADO A TURNO</option>
                <option value="TURNO EXTRA">TURNO EXTRA</option>
                <option value="HORA EXTRA">HORA EXTRA</option>
                <option value="OTRO">OTRO</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_estate">Estamento al que corresponde CS</label>
            <select name="estate" class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="Médico 44">Médico 19.664 (44hrs)</option>
                <option value="Médico 28">Médico 15.076 (28hrs)</option>
                <option value="Médico 22">Médico xx.xxx (22hrs)</option>
                <option value="Profesional">Profesional</option>
                <option value="Profesional Médico">Profesional Médico</option>
                <option value="Técnico">Técnico</option>
                <option value="Administrativo">Administrativo</option>
                <option value="Farmaceutico">Farmaceutico</option>
                <option value="Odontólogo">Odontólogo</option>
                <option value="Bioquímico">Bioquímico</option>
                <option value="Auxiliar">Auxiliar</option>
                <option value="Otro (justificar)">Otro (justificar)</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_descripcion">Monto</label>
            <input type="number" step="0.01" class="form-control" id="for_amount" name="amount" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_descripcion">Vigente desde</label>
            <input type="date" class="form-control" id="for_validity_from" name="validity_from" required>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>
@endsection

@section('custom_js')

@endsection
