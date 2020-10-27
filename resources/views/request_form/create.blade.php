@extends('layouts.app')

@section('title', 'Planes Comunales')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Formulario de Requerimiento N°1.</h3>

@include('request_form.nav')

<!-- FORM DE INGRESO DE TICKET -->
<form method="POST" class="form-horizontal" action="{{ route('request_forms.store') }}" enctype="multipart/form-data">
    @csrf <!-- input hidden contra ataques CSRF -->
    <div class="form-row">
        <div class="form-group col">
            <label for="forestimated_expense">Gasto Estimado o Presupuesto Programado:</label>
            <input type="text" class="form-control form-control-sm" id="forestimated_expense" placeholder="Ingrese el monto" name="estimated_expense" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-6">
            <label>Administrador Contrato: </label>
            <select class="form-control form-control-sm selectpicker" id="foradmin_id" name="admin_id" title="Seleccione..." data-live-search="true" data-size="5">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->fathers_family }} {{ $user->mothers_family }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-6">
            <label for="forprogram">Programa Asociado:</label>
            <input type="text" class="form-control form-control-sm" id="forprogram" placeholder="..." name="program" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col">
            <label for="forjustification">Justificación en Breve:</label>
            <input type="text" class="form-control form-control-sm" id="forjustification" placeholder="..." name="justification" required>
        </div>
    </div>

    <div class="form-row">
      <div class="form-group col-4">
          <label for="fortype_form">Tipo de Formulario Requerimiento: </label>
          <select class="form-control form-control-sm selectpicker" id="fortype_form" name="type_form" title="Seleccione..." data-size="5">
              <option value="item">Bienes y/o Servicios</option>
              <option value="passage">Pasajes Aéreos</option>
          </select>
      </div>
      <div class="form-group col-4">
          <label for="forprevious_request_form_id">N° de requerimiento previo: </label>
          <input type="number" class="form-control form-control-sm" id="forprevious_request_form_id" placeholder="..." name="previous_request_form_id">
      </div>
      <div class="form-group col-4">
        <label for="forbidding_number">ID Licitación: </label>
        <input type="text" class="form-control form-control-sm" id="forbidding_number" placeholder="..." name="bidding_number">
      </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="{{ route('request_forms.index') }}"
                class="btn btn-outline-secondary float-right">Cancelar
            </a>
            <button class="btn btn-primary float-right mr-3" type="submit">
                <i class="fas fa-save"></i> Enviar
            </button>
        </div>
    </div>

</form>

@endsection

@section('custom_js')

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script type="text/javascript">

    $("#other_value").hide();

    $("input[name=complaint_values_id]").click(function() {
        switch(this.value){
            case "8":
                $("#other_value").show("slow");
                break;
            default:
                $("#other_value").hide("slow");
                break;
        }
    });
</script>

@endsection

@section('custom_js_head')

@endsection
