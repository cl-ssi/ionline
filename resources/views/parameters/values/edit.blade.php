@extends('layouts.app')

@section('title', 'Valor Hora/Jornada')

@section('content')

@include('parameters/nav')
<h3 class="mb-3">Crear nuevo valor Hora/Jornada</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.values.update', $value) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_contract_type" >Tipo de Contrato*</label>
            <select name="contract_type" class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="Mensual" @if($value->contract_type == 'Mensual') selected @endif>Mensual</option>
                <option value="Horas" @if($value->contract_type == 'Horas') selected @endif >Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_type" >Tipo</label>
            <select name="type" class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="Covid" @if($value->type == 'Covid') selected @endif >Honorarios - Covid</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_guard_name">Jornada</label>
            <select id="for_work_type" name="work_type"  class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="DIURNO" @if($value->work_type == 'DIURNO') selected @endif >DIURNO</option>
                <option value="TERCER TURNO" @if($value->work_type == 'TERCER TURNO') selected @endif>TERCER TURNO</option>
                <option value="TERCER TURNO - MODIFICADO" @if($value->work_type == 'TERCER TURNO - MODIFICADO') selected @endif>TERCER TURNO - MODIFICADO</option>
                <option value="CUARTO TURNO" @if($value->work_type == 'CUARTO TURNO') selected @endif>CUARTO TURNO</option>
                <option value="CUARTO TURNO - MODIFICADO" @if($value->work_type == 'CUARTO TURNO - MODIFICADO') selected @endif>CUARTO TURNO - MODIFICADO</option>
                <option value="HORA MÉDICA" @if($value->work_type == 'HORA MÉDICA') selected @endif>HORA MÉDICA</option>
                <option value="DIURNO PASADO A TURNO" @if($value->work_type == 'DIURNO PASADO A TURNO') selected @endif>DIURNO PASADO A TURNO</option>
                <option value="OTRO" @if($value->work_type == 'OTRO') selected @endif>OTRO</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_estate">Estamento al que corresponde CS</label>
            <select name="estate" class="form-control" required>
                <option value="Médico 44" {{ ($value->estate == 'Médico 44')? 'selected' : ''}}>Médico 19.664 (44hrs)</option>
                <option value="Médico 28" {{ ($value->estate == 'Médico 28')? 'selected' : ''}}>Médico 15.076 (28hrs)</option>
                <option value="Médico 22" {{ ($value->estate == 'Médico 22')? 'selected' : ''}}>Médico xx.xxx (22hrs)</option>
                <option value="Profesional" @if($value->estate == 'Profesional') selected @endif >Profesional</option>
                <option value="Técnico" @if($value->estate == 'Técnico') selected @endif >Técnico</option>
                <option value="Administrativo" @if($value->estate == 'Administrativo') selected @endif >Administrativo</option>
                <option value="Farmaceutico" @if($value->estate == 'Farmaceutico') selected @endif >Farmaceutico</option>
                <option value="Odontólogo" @if($value->estate == 'Odontólogo') selected @endif >Odontólogo</option>
                <option value="Bioquímico" @if($value->estate == 'Bioquímico') selected @endif >Bioquímico</option>
                <option value="Auxiliar" @if($value->estate == 'Auxiliar') selected @endif >Auxiliar</option>
                <option value="Otro (justificar)" @if($value->estate == 'Otro (justificar)') selected @endif >Otro (justificar)</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_descripcion">Monto</label>
            <input type="number" step="0.01" class="form-control" id="for_amount" name="amount" value="{{$value->amount}}" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_descripcion">Vigencia desde</label>
            <input type="date" class="form-control" id="for_validity_from" name="validity_from" value="{{$value->validity_from}}" required>
        </fieldset>
    </div>




    <button type="submit" class="btn btn-primary">Actualizar</button>

</form>
@endsection

@section('custom_js')

@endsection
