@extends('layouts.app')

@section('title', 'Valor Hora/Jornada')

@section('content')

@include('parameters/nav')
<h3 class="mb-3">Crear nuevo valor Hora/Jornada</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.values.update', $value) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col-6 col-md-4">
            <label for="for_contract_type" >Tipo de Contrato*</label>
            <select name="contract_type" class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="Mensual" @if($value->contract_type == 'Mensual') selected @endif>Mensual</option>
                <option value="Horas" @if($value->contract_type == 'Horas') selected @endif >Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-4">
            <label for="for_type" >Tipo</label>
            <select name="type" class="form-control" required>
                <option value="">Seleccionar</option>
                <option value="Covid" @if($value->type == 'Covid') selected @endif >Honorarios - Covid</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-4">
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

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_descripcion">Monto</label>
            <input type="number" class="form-control" id="for_amount" name="amount" value="{{$value->amount}}" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_descripcion">Vigencia</label>
            <input type="date" class="form-control" id="for_validity_from" name="validity_from" value="{{$value->validity_from}}" required>
        </fieldset>
    </div>




    <button type="submit" class="btn btn-primary">Actualizar</button>

</form>
@endsection

@section('custom_js')

@endsection