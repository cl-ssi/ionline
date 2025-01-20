@extends('layouts.bt4.external')

@section('title', 'Nuevo Staff')

@section('content')

<br>

<h5>Antecedentes Personales / Contacto</h5>
<br>
<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.store') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-row">
        <fieldset class="form-group col-sm-2">
            <label for="for_run">RUT</label>
            <input type="text" class="form-control" name="run" id="for_run" value="{{ $userexternal->id }}" readonly>
        </fieldset>
        <fieldset class="form-group col-sm-1">
            <label for="for_dv">DV</label>
            <input type="text" class="form-control" name="dv" id="for_dv" value="{{ $userexternal->dv }}" readonly>
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
            <input type="text" class="form-control" name="name" id="for_name" value="{{ $userexternal->name }}" readonly>
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_name">Apellido Paterno</label>
            <input type="text" class="form-control" name="fathers_family" id="for_fathers_family" value="{{ $userexternal->fathers_family }}" readonly>
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_name">Apellido Materno</label>
            <input type="text" class="form-control" name="mothers_family" id="for_mothers_family" value="{{ old('mothers_family', $userexternal->mothers_family ?? 'S/A') }}" readonly>
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_gender" >Género</label>
            <select name="gender" id="for_gender" class="form-control" required>
                <option value="">Seleccione...</option>
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
            <input type="email" class="form-control" name="email" id="for_email" required>
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
        @livewire('replacement-staff.commune-region-select')

        <fieldset class="form-group col">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" name="address" id="for_address"  placeholder="" required>
        </fieldset>
    </div>

    <div class="form-row">
      <fieldset class="form-group col-6">
          <label for="for_status">Disponibilidad</label>
          <select name="status" id="for_status" class="form-control" required>
              <option value="">Seleccione...</option>
              <option value="immediate_availability">Inmediata</option>
              <option value="working_external">Trabajando</option>
          </select>
      </fieldset>
      <fieldset class="form-group col mt">
          <div class="mb-3">
              <label for="forcv_file" class="form-label">Adjuntar Curriculum</label>
              <input class="form-control" type="file" name="cv_file" id="for_cv_file" accept="application/pdf" required>
          </div>
      </fieldset>
    </div>

    <hr>
    <h5>Perfil Profesional</h5>
    <br>

    @livewire('replacement-staff.profile')

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>

</form>

<br><br><br>

@endsection

@section('custom_js')

<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<script>
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });


  $('#for_cv_file').bind('change', function() {
      //Validación de tamaño
      if((this.files[0].size / 1024 / 1024) > 3){
          alert('No puede cargar un pdf de mas de 3 MB.');
          $('#for_cv_file').val('');
      }

      //Validación de pdf
      const allowedExtension = ".pdf";
      let hasInvalidFiles = false;

      for (let i = 0; i < this.files.length; i++) {
          let file = this.files[i];

          if (!file.name.endsWith(allowedExtension)) {
              hasInvalidFiles = true;
          }
      }

      if(hasInvalidFiles) {
          $('#for_cv_file').val('');
          alert("Debe seleccionar un archivo pdf.");
      }

  });
</script>

@endsection
