@extends('layouts.bt4.app')

@section('title', 'Solicitud')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-file"></i> Formulario Solicitud Contratación de Personal</h5>

<br>

<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.store') }}" enctype="multipart/form-data"/>
    @csrf
    @method('POST')
    
    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-6">
            <label for="for_requester_name">Creador de Solicitud</label>
            <input type="text" class="form-control" name="requester_name" id="for_requester_name" value="{{ auth()->user()->tinyName }}" disabled>
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_user_id">Funcionario Solicitante</label>
            @livewire('search-select-user')
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-sm">
            <label for="for_name">Nombre de Cargo</label>
            <input type="text" class="form-control" name="name" id="for_name" required>
        </fieldset>

        @livewire('replacement-staff.show-profile-request')

        <fieldset class="form-group col-sm">
            <label for="for_start_date">Desde</label>
            <input type="date" class="form-control" name="start_date" id="for_start_date" required>
        </fieldset>

        <fieldset class="form-group col-sm">
            <label for="for_end_date">Hasta</label>
            <input type="date" class="form-control" name="end_date" id="for_end_date" required>
        </fieldset>
    </div>

    <div class="form-row">
        @livewire('calculate-dv')

        <fieldset class="form-group col-sm">
            <label for="for_end_date">Funcionario a Reemplazar</label>
            <input type="text" class="form-control" name="name_to_replace" id="for_name_to_replace"
                placeholder="Nombre de Reemplazo"
                required>
        </fieldset>
    </div>

    <div class="form-row">
        @livewire('replacement-staff.show-legal-quality-request')
    </div>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label for="for_calidad_juridica">Jornada</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_diurnal" value="diurnal" required>
                    <label class="form-check-label" for="for_work_day_diurnal">Diurno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_third_shift" value="third shift" required>
                    <label class="form-check-label" for="for_work_day_third_shift">Tercer Turno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_fourth_shift" value="fourth shift" required>
                    <label class="form-check-label" for="for_work_day_fourth_shift">Cuarto Turno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_other" value="other" required>
                    <label class="form-check-label" for="for_work_day_other">Otro</label>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_name">Otra Jornada</label>
            <input type="text" class="form-control" name="other_work_day" id="for_other_work_day" placeholder="Otro">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_charges_number">Nº Cargos</label>
            <input type="number" class="form-control" name="charges_number" value="1" id="for_charges_number" readonly>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-6">
            <div class="mb-3">
                <label for="for_job_profile_file" class="form-label">Perfil de Cargo (Opcional)</label>
                <input class="form-control" type="file" name="job_profile_file" accept="application/pdf">
            </div>
        </fieldset>

        <fieldset class="form-group col-md-6">
            <div class="mb-3">
                <label for="for_request_verification_file" class="form-label">Correo (Verificación Solicitud)</label>
                <input class="form-control" type="file" name="request_verification_file" accept="application/pdf" required>
            </div>
        </fieldset>
    </div>

    <div class="form-row">
        @livewire('replacement-staff.ou-staff-select')
    </div>

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

<br><br>

@endsection

@section('custom_js')

<script type="text/javascript">
    document.getElementById('for_other_work_day').readOnly = true;

    // NAME Option
    $("input[name=work_day]").click(function() {
        switch(this.value){
            case "other":
                document.getElementById('for_other_work_day').readOnly = false;
                break;
            default:
                document.getElementById('for_other_work_day').readOnly = true;
                document.getElementById('for_other_work_day').value = '';
                break;
        }
    });

    function remoteWorking() {
        //get the selected value from the dropdown list
        var mylist = document.getElementById("for_fundament_detail_manage_id");
        var result = mylist.options[mylist.selectedIndex].text;

        if (result == 'Teletrabajo (Funciones no habituales)') {
          //disable all the radio button
          document.getElementById("for_work_day_diurnal").disabled = true;
          document.getElementById("for_work_day_other").disabled = true;
        }
        else {
          //enable all the radio button
          document.getElementById("for_work_day_diurnal").disabled = false;
          document.getElementById("for_work_day_other").disabled = false;
        }
    }
</script>

@endsection
