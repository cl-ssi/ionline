@extends('layouts.app')

@section('title', 'Solicitud')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-file"></i> Editar Formulario de Convocatorias</h5>

<br>

<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.update', $requestReplacementStaff) }}" enctype="multipart/form-data"/>
    @csrf
    @method('PUT')

    <h6 class="small"><b>1. Usuarios solicitantes</b></h6> <br>
    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-6">
            <label for="for_creator_name">Creador de Solicitud</label>
            <input type="text" class="form-control" name="creator_name" id="for_creator_name" value="{{ $requestReplacementStaff->user->TinnyName }}" disabled>
        </fieldset>

        <fieldset class="form-group col-6 col-md-6">
            <label for="for_user_id">Funcionario Solicitante</label>
            @livewire('search-select-user', [
                'selected_id' => 'requester_id',
                'user'        => $requestReplacementStaff->requesterUser    
            ])
        </fieldset>
    </div>

    <hr>

    <h6 class="small"><b>2. Descripción de Solicitud</b></h6> <br>
    
    <div class="form-row">
        <fieldset class="form-group col-6 col-sm-6">
            <label for="for_name">Nombre de Solicitud</label>
            <input type="text" class="form-control" name="name" id="for_name" value="{{ $requestReplacementStaff->name }}" 
                placeholder="EJ: Reemplazo por licencia médica de funcionario de establecimiento..." required>
        </fieldset>

        <fieldset class="form-group col-1">
            <div>
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

        <fieldset class="form-group col-5">     
            <div>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Resoluciones, Decretos y/o Antecedentes asociados al cargo">
                <label for="for_request_verification_file" class="form-label">Antecedentes del proceso <i class="fas fa-info-circle"></i></label>
                </span>
                <input class="form-control" type="file" name="request_verification_file" accept="application/pdf">
            </div>
        </fieldset>
    </div>

    <hr>
    
    @livewire('replacement-staff.position-form-edit', [
            'requestReplacementStaff' => $requestReplacementStaff
        ])

    <hr>

    <h6 class="small"><b>4. Descripción de Unidad Organizacional</b></h6> <br>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_ou_id">
                Unidad Organizacional
            </label>
            @livewire('search-select-organizational-unit', [
                'selected_id'         => 'ou_of_performance_id',
                'required'            => 'required',
                'organizationalUnit' => $requestReplacementStaff->ouPerformance
            ])
        </fieldset>
    </div>
    
    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

<br><br>

{{-- @if(Auth::user()->hasRole('Replacement Staff: admin')) --}}
<br/>

<hr/>
<div style="height: 300px; overflow-y: scroll;">
    @include('partials.audit', ['audits' => $requestReplacementStaff->audits()] )
</div>

{{-- @endif --}}

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