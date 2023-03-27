@extends('layouts.app')

@section('title', 'Solicitud')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-file"></i> Nuevo Formulario de Convocatorias</h5><br>

<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.store', ['formType' => 'announcement']) }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    
    <h6 class="small"><b>1. Usuarios solicitantes</b></h6> <br>
    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-6">
            <label for="for_requester_name">Creador de Solicitud</label>
            <input type="text" class="form-control" name="requester_name" value="{{Auth::user()->TinnyName}}" disabled>
        </fieldset>

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_user_id">Funcionario Solicitante</label>
            @livewire('search-select-user', [
                'selected_id'   => 'requester_id',
                'required'      => 'required'
            ])
        </fieldset>
    </div>

    <hr>

    <h6 class="small"><b>2. Descripción de Solicitud</b></h6> <br>
    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-6">
            <label for="for_name">Nombre de Solicitud</label>
            <input type="text" class="form-control" name="name"
                placeholder="EJ: Reemplazo por licencia médica de funcionario de establecimiento..." required>
        </fieldset>
        <fieldset class="form-group col-12 col-md-6">
            <div class="mb-3">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Resoluciones, Decretos y/o Antecedentes asociados al cargo">
                <label for="for_request_verification_file" class="form-label">Antecedentes del proceso de contración <i class="fas fa-info-circle"></i></label>
                </span>
                <input class="form-control" type="file" name="request_verification_file" accept="application/pdf" required>
            </div>
        </fieldset>
    </div>
    <hr>
    <h6 class="small"><b>3. Descripción de cargo</b></h6> <br>
    
    @livewire('replacement-staff.show-legal-quality-request', ['formType'  => 'announcement'])
    
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
            <input type="number" class="form-control" name="charges_number" value="1" id="for_charges_number">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-6">
            <label for="for_job_profile_file" class="form-label">Perfil de Cargo</label>
            <input class="form-control" type="file" name="job_profile_file" accept="application/pdf" required>
        </fieldset>
    </div>

    <h6 class="small"><b>4. Descripción de Unidad Organizacional</b></h6> <br>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_ou_id">
                Unidad Organizacional
            </label>
            @livewire('search-select-organizational-unit', [
                'selected_id'   => 'ou_of_performance_id',
                'required'      => 'required',
            ])
        </fieldset>
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