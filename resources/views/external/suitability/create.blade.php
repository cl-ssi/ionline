@extends('layouts.external')

@section('content')

<h3 class="mb-3">Nueva Solicitud de Evaluación de Idoneidad Psicológica para el colegio </h3>
<h6 class="mb-3"><strong>Recordar revisar el Historico de Solicitudes en "Mis Solitudes" antes de generar una nueva</strong></h6>
<h6 class="mb-3"><strong>Para personas que ingresaron a trabajar antes del 01-03-2009 NO se le debe generar solicitud de idoneidad</strong></h6>



<form method="POST" class="form-horizontal" action="{{ route('idoneidad.storeExternal') }}">
    @csrf
    @method('POST')
    <input id="school_id" name="school_id" type="hidden" value="{{$school->id}}">
    <div class="form-row align-items-end">
        <fieldset class="form-group col-5 col-sm-4 col-md-4 col-lg-2">
            <label for="for_run">Run</label>
            <input type="number" class="form-control" id="for_run" name="id" autocomplete="off" max="50000000"  required>
        </fieldset>
        <fieldset class="form-group col-2 col-sm-2 col-md-1 col-lg-1">
            <label for="for_dv">DV</label>
            <input type="text" class="form-control" id="for_dv" name="dv" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-4">
            <label>Sexo*</label>
            <select class="form-control" name="gender">
                <option value="">Seleccionar Sexo</option>
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
            </select>
        </fieldset>
    </div>

    <div class="row">
        <fieldset class="form-group col-6">
            <label for="for_name">Nombres*</label>
            <input type="text" class="form-control" id="for_name" placeholder="" name="name" required="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_fathers_family">Apellido Paterno*</label>
            <input type="text" class="form-control" id="for_fathers_family" placeholder="" name="fathers_family" required="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_mothers_family">Apellido Materno*</label>
            <input type="text" class="form-control" id="for_mothers_family" placeholder="" name="mothers_family" required="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_critic_stock">Correo Electrónico*</label>
            <input type="email" class="form-control" id="" placeholder="" name="email" required="" autocomplete="off">
        </fieldset>
    </div>

    <div class="row">
        <fieldset class="form-group col-6">
            <label for="for_job">Cargo Desempeñado*</label>
            <input type="text" class="form-control" id="for_job" placeholder="" name="job" required="">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_start_date">Fecha de Ingreso*</label>
            <input type="date" class="form-control" id="for_start_date" placeholder="" name="start_date" min="2009-03-01" max="{{Carbon\Carbon::now()->toDateString()}}" required="">
        </fieldset>
    </div>

    <div class="row">
        <fieldset class="form-group col-6">
            <label for="for_country">Nacionalidad*</label>
            <input type="text" class="form-control" id="for_country" placeholder="" name="country" required="">
        </fieldset>
    </div>

    <label for="forBrand">Presenta Discapacidad*</label>
    <fieldset class="form-group">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="disability" id="RadioType1" value="1" required>
            <label class="form-check-label" for="inlineRadio1">Sí</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="disability" id="RadioType2" value="0" required>
            <label class="form-check-label" for="inlineRadio2">No</label>
        </div>
    </fieldset>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection

@section('custom_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{ asset('js/jquery.rut.chileno.js') }}"></script>
<script type="text/javascript">
            //obtiene digito verificador
            $('input[name=id]').keyup(function(e) {
                var str = $("#for_run").val();
                $('#for_dv').val($.rut.dv(str));
            });
</script>

@endsection