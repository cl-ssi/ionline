@extends('layouts.bt4.app')

@section('title', '- Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento {{$requestForm ? 'ID '.$requestForm->id : ''}} - {{ request()->route()->getName() == 'request_forms.items.create' || ($requestForm && $requestForm->type_form == 'bienes y/o servicios') ? 'Bienes y/o Servicios' : 'Pasajes Aéreos' }}</h4>

@include('request_form.partials.nav')

<div class="card">
  <div class="card-header">
    <i class="fas fa-user"></i> Datos del Solicitante:</h6>
  </div>
  <div class="card-body">
    <div class="form-row">
      <fieldset class="form-group col-sm-2">
          <label for="forRut" class="form-label">Rut:</label>
          <input class="form-control form-control-sm" type="text" id="rut" name="rut" value="{{ auth()->user()->runFormat() }}" readonly>
      </fieldset>

      <fieldset class="form-group col-sm-4">
          <label for="forNombres" class="form-label">Nombre:</label>
          <input class="form-control form-control-sm" type="text" name="" id="nombres" name="nombres" value="{{ auth()->user()->fullName }}" readonly>
      </fieldset>

      <fieldset class="form-group col-sm-3">
          <label for="forCorreo">Correo:</label>
          <input class="form-control form-control-sm" type="text" name="" id="correo" name="correo" value="{{ auth()->user()->email }}" readonly>
      </fieldset>

      <fieldset class="form-group col-sm-3">
          <label for="forUnidad">Unidad:</label>
          <input class="form-control form-control-sm" type="text" name="" id="unidad" name="unidad" value="{{ auth()->user()->organizationalUnit->name }}" readonly>
      </fieldset>
    </div>

  </div>
</div>

<br>

@livewire('request-form.request-form-create', ['requestForm' => $requestForm, 'purchasePlan' => $purchasePlan ?? null])

@endsection

@section('custom_js')

<script>
    $('[data-toggle="tooltip"]').tooltip()
   
  // $(document).ready(function(){
  //   anElement = new AutoNumeric('#quantity_format', AutoNumeric.getPredefinedOptions().commaDecimalCharDotSeparator);
  //   anElement = new AutoNumeric('#price_format', AutoNumeric.getPredefinedOptions().commaDecimalCharDotSeparator);
  //   anElement.clear();
  // })

  // function disableButton(form) {
  //   form.submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';
  //   form.submitBtn.disabled = true;
  //   return true;
  // }

  $('input[type="file"]').bind('change', function(e) {
    //Validación de tamaño
    for (let i = 0; i < this.files.length; i++) {
      if((this.files[i].size / 1024 / 1024) > 5){
          alert('No puede cargar archivos de más de 5 MB.');
          $(this).val('');
          break;
      }
    }
    //Validación de pdf
    // const allowedExtension = ".pdf";
    // let hasInvalidFiles = false;

    // for (let i = 0; i < this.files.length; i++) {
    //     let file = this.files[i];

    //     if (!file.name.endsWith(allowedExtension)) {
    //         hasInvalidFiles = true;
    //     }
    // }

    // if(hasInvalidFiles) {
    //     $('#for_document').val('');
    //     alert("Debe seleccionar un archivo pdf.");
    // }
  });

  
</script>

@endsection
