@extends('layouts.external')

@section('title', 'Nuevo Staff')

@section('content')



<h5>Ingreso de nuevo staff {{Auth::guard('external')->user()->id}}</h5>

<br>

<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.store') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-row">
        <fieldset class="form-group col-sm-2">
            <label for="for_run">RUT</label>
            <input type="text" class="form-control" name="run" id="for_run">
        </fieldset>
        <fieldset class="form-group col-sm-1">
            <label for="for_dv">DV</label>
            <input type="text" class="form-control" name="dv" id="for_dv">
        </fieldset>

        <fieldset class="form-group col-sm-3">
            <label for="for_birthday">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="for_birthday" min="1900-01-01" max="{{Carbon\Carbon::now()->toDateString()}}"
                name="birthday" required>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_name">Nombres</label>
            <input type="text" class="form-control" name="name" id="for_name">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_name">Apellido Paterno</label>
            <input type="text" class="form-control" name="fathers_family" id="for_fathers_family">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_name">Apellido Materno</label>
            <input type="text" class="form-control" name="mothers_family" id="for_mothers_family">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_gender" >Género</label>
            <select name="gender" id="for_gender" class="form-control selectpicker" title="Seleccione...">
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
                <option value="other">Otro</option>
                <option value="unknown">Desconocido</option>
            </select>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label for="for_email">Correo Electrónico</label>
            <input type="text" class="form-control" name="email" id="for_email">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_telephone">Teléfono Movil</label>
            <input type="text" class="form-control" name="telephone" id="for_telephone"  placeholder="+569xxxxxxxx">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_telephone2">Teléfono Fijo</label>
            <input type="text" class="form-control" name="telephone2" id="for_telephone2"  placeholder="572xxxxxx">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_commune_id">Comuna</label>
            <select name="commune" id="for_commune" class="form-control selectpicker" title="Seleccione...">
                <option value="camina">Camiña</option>
                <option value="colchane">Colchane</option>
                <option value="huara">Huara</option>
                <option value="iquique">Iquique</option>
                <option value="pica">Pica</option>
                <option value="pozo almonte">Pozo Almonte</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" name="address" id="for_address"  placeholder="">
        </fieldset>
    </div>

    <div class="form-row">
      <fieldset class="form-group col-6">
          <label for="for_status">Disponibilidad</label>
          <select name="status" id="for_status" class="form-control selectpicker" title="Seleccione...">
              <option value="immediate_availability">Inmediata</option>
              <option value="working_external">Trabajando</option>
          </select>
      </fieldset>
      <fieldset class="form-group col mt">
          <div class="mb-3">
              <label for="forcv_file" class="form-label">Adjuntar Curriculum</label>
              <input class="form-control" type="file" name="cv_file" accept="application/pdf" required>
          </div>
      </fieldset>
    </div>

    <button type="submit" class="btn btn-primary float-right">Guardar</button>

</form>

<br><br>


    <!-- <div class="form-row">
        <div class="form-group col mt">
            <label for="for_profession">Profesión</label>
            <select name="profession" id="for_profession" class="form-control selectpicker">
                <option value="Enfermera">Enfermera</option>
                <option value="Informatica">Informática</option>
            </select>
        </div>

        <div class="form-group col mt">
            <label for="for_profession"><br></label>
            <div class="form-group custom-file col mt">
                <input type="file" class="custom-file-input"  name="file" required>
                <label class="custom-file-label" for="customFile">Seleccione el archivo</label>
            </div>
        </div>
    </div> -->

    <!-- <hr>

    <h5>Experiencia </h5>

    <br>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_experiencias_anteriores">Experiencias Anteriores (2*)</label>
            <input type="text" class="form-control" name="experiencias_anteriores" id="for_experiencias_anteriores" placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Funciones Realizadas</label>
            <input type="text" class="form-control" name="funciones_realizada" id="for_funciones_realizada" placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Referencia</label>
            <input type="text" class="form-control" name="referencia" id="for_funciones_realizada" placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_profession">Certificado de Experiencia Laboral</label>
            <input type="file" class="form-control" name="direccion" id="for_direccion" placeholder="">
        </fieldset>
    </div>

    <hr>
    <legend>PERFECCIONAMIENTO/CAPACITACIONES: <i class="fas fa-plus"></i></legend>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_experiencias_anteriores">Nombre Capacitación</label>
            <input type="text" class="form-control" name="experiencias_anteriores" id="for_experiencias_anteriores" placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Número de horas</label>
            <input type="text" class="form-control" name="funciones_realizada" id="for_funciones_realizada" placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_funciones_realizada">Certificado</label>
            <input type="file" class="form-control"  placeholder="">
        </fieldset>
    </div>
    <hr>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_experiencias_anteriores">Otra Observación</label>
            <textarea class="form-control"></textarea>
        </fieldset>
    </div>

    <fieldset class="form-group col">
            <label for="for_etamento">Idioma</label>
            <select name="etamento" id="for_etamento" class="form-control">
                <option value=""></option>
                <option value="">Inglés</option>
                <option value="">Frances</option>
                <option value="">Aleman</option>
            </select>
        </fieldset> -->

@endsection

@section('custom_js')

<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script>
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
</script>

@endsection
