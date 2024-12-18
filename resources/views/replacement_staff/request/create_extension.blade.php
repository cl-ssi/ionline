@extends('layouts.bt4.app')

@section('title', 'Extensión de Solicitud')

@section('content')

@include('replacement_staff.nav')

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <thead>
            <tr class="table-active">
                <th colspan="3">Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}
                    @switch($requestReplacementStaff->request_status)
                        @case('pending')
                            <span class="badge bg-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                            @break

                        @case('complete')
                            <span class="badge bg-success">{{ $requestReplacementStaff->StatusValue }}</span>
                            @break

                        @case('rejected')
                            <span class="badge bg-danger">{{ $requestReplacementStaff->StatusValue }}</span>
                            @break

                        @default
                            Default case...
                    @endswitch
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="table-active">Por medio del presente</th>
                <td colspan="2">
                    {{ $requestReplacementStaff->organizationalUnit->name }}
                </td>
            </tr>
            <tr>
                <th class="table-active">Nombre / Nº de Cargos</th>
                <td style="width: 33%">{{ $requestReplacementStaff->name }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->charges_number }}</td>
            </tr>
            <tr>
                <th class="table-active">Estamento / Grado</th>
                <td style="width: 33%">{{ $requestReplacementStaff->profile_manage->name }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->degree }}</td>
            </tr>
            <tr>
                <th class="table-active">Calidad Jurídica / $ Honorarios</th>
                <td style="width: 33%">{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                <td style="width: 33%">
                  @if($requestReplacementStaff->LegalQualityValue == 'Honorarios')
                      ${{ number_format($requestReplacementStaff->salary,0,",",".") }}
                  @endif
                </td>
            </tr>
            <tr>
                <th class="table-active">La Persona cumplirá labores en Jornada</th>
                <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
            </tr>
            <tr>
                <th class="table-active">
                  Fundamento de la Contratación<br>
                  Detalle de Fundamento
                </th>
                <td style="width: 33%">
                  {{ $requestReplacementStaff->fundamentManage->NameValue }}<br>
                  {{ ($requestReplacementStaff->fundamentDetailManage) ? $requestReplacementStaff->fundamentDetailManage->NameValue : '' }}
                </td>
                <td style="width: 33%">De funcionario: {{ $requestReplacementStaff->name_to_replace }}</td>
            </tr>
            <tr>
                <th class="table-active">Otro Fundamento (especifique)</th>
                <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
            </tr>
            <tr>
                <th class="table-active">Periodo</th>
                <td style="width: 33%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                <td style="width: 33%">{{ $requestReplacementStaff->end_date->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th class="table-active">Archivos</th>
                <td style="width: 33%">Perfil de Cargo
                  @if($requestReplacementStaff->job_profile_file)
                      <a href="{{ route('replacement_staff.request.show_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a>
                  @endif
                </td>
                <td style="width: 33%">Correo (Verificación Solicitud) <a href="{{ route('replacement_staff.request.show_verification_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a></td>
            </tr>
            <tr>
                <th class="table-active">Lugar de Desempeño</th>
                <td colspan="2">{{ $requestReplacementStaff->ouPerformance->name }}</td>
            </tr>
            <tr>
                <th class="table-active">Staff Sugerido</th>
                <td colspan="2">
                  @if($requestReplacementStaff->replacementStaff)
                      {{ $requestReplacementStaff->replacementStaff->fullName }}
                  @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

<br>

<h5><i class="fas fa-file"></i> Nueva Extensión de Formulario de Reemplazos</h5>

<br>

<div class="alert alert-info" role="alert">
    <div class="row">
        <div class="col-md-10 col-12">
            Revisa aquí el <b>Calendario de Cierre Remuneraciones 2024</b>
        </div>
        <div class="col-md-2 col-12">
            @livewire('replacement-staff.remuneration-schedule')
        </div>
    </div>
</div>

<br>

<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.store_extension', [
    'requestReplacementStaff' => $requestReplacementStaff,
    'formType'                => 'replacement',
    ]) }}"
    enctype="multipart/form-data"/>
    @csrf
    @method('POST')
    
    <h6 class="small"><b>1. Usuarios solicitantes</b></h6> <br>
    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-6">
            <label for="for_requester_name">Creador de Solicitud</label>
            <input type="text" class="form-control" name="requester_name" id="for_requester_name" value="{{ auth()->user()->tinyName }}" disabled>
        </fieldset>

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_user_id">Funcionario Solicitante</label>
                @livewire('search-select-user',[
                    'selected_id' => 'requester_id',
                    'required'    => 'required'
                ])
        </fieldset>    
    </div>

    <hr>

    <h6 class="small"><b>2. Descripción de Solicitud</b></h6> <br>
        
    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-6">
            <label for="for_name">Nombre de Cargo</label>
            <input type="text" class="form-control" name="name" value="Extensión {{ $requestReplacementStaff->name }}"
                id="for_name" required>
        </fieldset>

        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_start_date">Desde</label>
            <input type="date" class="form-control" name="start_date" value="{{ $requestReplacementStaff->end_date->format('Y-m-d') }}"
                        id="for_start_date" required>
        </fieldset>

        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_end_date">Hasta</label>
            <input type="date" class="form-control" name="end_date"
                id="for_end_date" required>
        </fieldset>
    </div>

    @livewire('replacement-staff.show-legal-quality-request', [
        'formType'                => 'replacement',
        'requestReplacementStaff' => $requestReplacementStaff 
    ])

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
            <input type="text" class="form-control" name="other_work_day"
                id="for_other_work_day" placeholder="Otro">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_charges_number">Nº Cargos</label>
                <input type="number" class="form-control" name="charges_number" value="{{ $requestReplacementStaff->charges_number }}"
                    id="for_charges_number" value="1" readonly required>
        </fieldset>
    </div>

    <hr>

    <h6 class="small"><b>3. Descripción de Funcionario a Reemplazar</b></h6> <br>
    <div class="form-row">
        @livewire('calculate-dv', [
            'requestReplacementStaff'     =>  $requestReplacementStaff
        ])

        @livewire('replacement-staff.name-to-replace', [
            'requestReplacementStaff'     =>  $requestReplacementStaff
        ])
    </div>
            
    <hr>

    <h6 class="small"><b>4. Archivos Adjuntos</b></h6> <br>
    <div class="form-row">
        {{--
        <fieldset class="form-group col-md-6">
            <div class="mb-3">
                <label for="for_job_profile_file" class="form-label">Perfil de Cargo</label>
                <input class="form-control" type="file" name="job_profile_file"
                    accept="application/pdf">
            </div>
        </fieldset>
        --}}
        
        <fieldset class="form-group col-md-6">
            <div class="mb-3">
                <label for="for_request_verification_file" class="form-label">Correo de Respaldo <small>(Autorizaciones, VB de jefaturas superiores o directas)</small></label>
                <input class="form-control" type="file" name="request_verification_file"
                    accept="application/pdf" required>
            </div>
        </fieldset>
    </div>

    <hr>

    <h6 class="small"><b>5. Descripción de Unidad Organizacional</b></h6> <br>

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
