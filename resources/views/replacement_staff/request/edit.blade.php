@extends('layouts.bt4.app')

@section('title', 'Solicitud')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-file"></i> Formulario Solicitud Contratación de Personal</h5>

<br>

<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.update', $requestReplacementStaff) }}" enctype="multipart/form-data"/>
    @csrf
    @method('PUT')

    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-6">
            <label for="for_requester_name">Creador de Solicitud</label>
            <input type="text" class="form-control" name="requester_name" id="for_requester_name" value="{{ auth()->user()->tinyName }}" disabled>
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_user_id">Funcionario Solicitante</label>
            @livewire('search-select-user', ['user' => $requestReplacementStaff->requesterUser])
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-sm">
            <label for="for_name">Nombre de Cargo</label>
            <input type="text" class="form-control" name="name" id="for_name" value="{{ $requestReplacementStaff->name }}" required>
        </fieldset>

        @livewire('replacement-staff.show-profile-request', ['requestReplacementStaff' => $requestReplacementStaff])

        <fieldset class="form-group col-sm">
            <label for="for_start_date">Desde</label>
            <input type="date" class="form-control" name="start_date" id="for_start_date" value="{{ $requestReplacementStaff->start_date->format('Y-m-d') }}" required>
        </fieldset>

        <fieldset class="form-group col-sm">
            <label for="for_end_date">Hasta</label>
            <input type="date" class="form-control" name="end_date" id="for_end_date" value="{{ $requestReplacementStaff->end_date->format('Y-m-d') }}" required>
        </fieldset>
    </div>

    <div class="form-row">
        @livewire('calculate-dv', ['requestReplacementStaff' => $requestReplacementStaff])

        <fieldset class="form-group col-sm">
            <label for="for_end_date">Funcionario a Reemplazar</label>
            <input type="text" class="form-control" name="name_to_replace" id="for_name_to_replace"
                placeholder="Nombre de Reemplazo" value="{{ $requestReplacementStaff->name_to_replace }}"
                required>
        </fieldset>
    </div>

    <div class="form-row">
        @livewire('replacement-staff.show-legal-quality-request', ['requestReplacementStaff' => $requestReplacementStaff])
    </div>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label for="for_calidad_juridica">Jornada</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_diurnal" value="diurnal"
                        {{ ($requestReplacementStaff->work_day == "diurnal")?'checked':''}} required>
                    <label class="form-check-label" for="for_work_day_diurnal">Diurno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_third_shift" value="third shift"
                        {{ ($requestReplacementStaff->work_day == "third shift")?'checked':''}} required>
                    <label class="form-check-label" for="for_work_day_third_shift">Tercer Turno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_fourth_shift" value="fourth shift"
                        {{ ($requestReplacementStaff->work_day == "fourth shift")?'checked':''}} required>
                    <label class="form-check-label" for="for_work_day_fourth_shift">Cuarto Turno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="work_day" id="for_work_day_other" value="other"
                        {{ ($requestReplacementStaff->work_day == "other")?'checked':''}} required>
                    <label class="form-check-label" for="for_work_day_other">Otro</label>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_name">Otra Jornada</label>
            <input type="text" class="form-control" name="other_work_day" id="for_other_work_day" placeholder="Otro"
                value="{{ $requestReplacementStaff->other_work_day }}">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_charges_number">Nº Cargos</label>
            <input type="number" class="form-control" name="charges_number" id="for_charges_number"
                value="{{ $requestReplacementStaff->charges_number }}" readonly>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="col-sm-1">
            <div class="mb-3">
                <label for="" class="form-label">&nbsp;</label>
                @if($requestReplacementStaff->job_profile_file)
                    <a class="btn btn-outline-secondary form-control"
                        href="{{ route('replacement_staff.request.show_file', $requestReplacementStaff) }}"
                        target="_blank"> <i class="fas fa-paperclip"></i>
                    </a>
                @else
                    <a class="btn btn-outline-secondary form-control disabled"
                        href=""
                        target="_blank"> <i class="fas fa-paperclip"></i>
                    </a>
                @endif
            </div>
        </fieldset>

        <fieldset class="form-group col-md-5">
            <div class="mb-3">
                <label for="for_job_profile_file" class="form-label">Perfil de Cargo (Opcional)</label>
                <input class="form-control" type="file" name="job_profile_file" accept="application/pdf">
            </div>
        </fieldset>

        <fieldset class="col-sm-1">
            <div class="mb-3">
                <label for="" class="form-label">&nbsp;</label>
                @if($requestReplacementStaff->request_verification_file)
                    <a class="btn btn-outline-secondary form-control"
                        href="{{ route('replacement_staff.request.show_verification_file', $requestReplacementStaff) }}"
                        target="_blank"> <i class="fas fa-paperclip"></i>
                    </a>
                @else
                    <a class="btn btn-outline-secondary form-control disabled"
                        href=""
                        target="_blank"> <i class="fas fa-paperclip"></i>
                    </a>
                @endif
            </div>
        </fieldset>

        <fieldset class="form-group col-md-5">
            <div class="mb-3">
                <label for="for_request_verification_file" class="form-label">Correo (Verificación Solicitud)</label>
                <input class="form-control" type="file" name="request_verification_file" accept="application/pdf">
            </div>
        </fieldset>
    </div>

    <div class="form-row">
        @livewire('replacement-staff.ou-staff-select', ['requestReplacementStaff' => $requestReplacementStaff])
    </div>

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

<br><br>

@if(auth()->user()->can('Replacement Staff: admin'))
<br/>

<hr/>
<div style="height: 300px; overflow-y: scroll;">
    @include('partials.audit', ['audits' => $requestReplacementStaff->audits()] )
</div>

@endif

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
