@extends('layouts.app')

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
                  {{ $requestReplacementStaff->fundamentDetailManage->NameValue }}
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
        </tbody>
    </table>
</div>

<!-- <div class="card">
    <div class="card-header">
        Formulario de Extensión para Solicitud Contratación de Personal
    </div>
    <div class="card-body">

        <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.store_extension', $requestReplacementStaff) }}">
            @csrf
            @method('POST')

            <div class="form-row">


                <fieldset class="form-group col-2">
                    <label for="degree">Grado</label>
                    <input type="number" class="form-control" name="degree"
                        id="for_degree" min="1" max="26" value="{{ $requestReplacementStaff->degree }}" required>
                </fieldset>

                <fieldset class="form-group col-4">
                    <label for="for_legal_quality" >Calidad Jurídica</label>
                    <select name="legal_quality" id="for_legal_quality" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <option value="to hire" {{ ($requestReplacementStaff->legal_quality == 'to hire')?'selected':'' }}>Contrata</option>
                        <option value="fee" {{ ($requestReplacementStaff->legal_quality == 'fee')?'selected':'' }}>Honorarios</option>
                    </select>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-6">
                    <label for="for_calidad_juridica">Jornada</label>
                    <div class="mt-1">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="work_day" id="for_work_day_diurnal" value="diurnal"
                              {{ ($requestReplacementStaff->work_day == "diurnal")? "checked" : "" }} required>
                          <label class="form-check-label" for="for_work_day_diurnal">Diurno</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="work_day" id="for_work_day_third_shift" value="third shift"
                              {{ ($requestReplacementStaff->work_day == "third_shift")? "checked" : "" }} required>
                          <label class="form-check-label" for="for_work_day_third_shift">Tercer Turno</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="work_day" id="for_work_day_fourth_shift" value="fourth shift"
                              {{ ($requestReplacementStaff->work_day == "fourth_shift")? "checked" : "" }} required>
                          <label class="form-check-label" for="for_work_day_fourth_shift">Cuarto Turno</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="work_day" id="for_work_day_other" value="other"
                              {{ ($requestReplacementStaff->work_day == "other")? "checked" : "" }} required>
                          <label class="form-check-label" for="for_work_day_other">Otro</label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_name">&nbsp;</label>
                    <input type="text" class="form-control" name="other_work_day"
                        id="for_other_work_day" placeholder="Otro" value="{{ $requestReplacementStaff->other_work_day }}">
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="for_start_date">Desde</label>
                    <input type="date" class="form-control" name="start_date"
                        id="for_start_date" value="{{ $requestReplacementStaff->end_date->format('Y-m-d')  }}" required>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_end_date">Hasta</label>
                    <input type="date" class="form-control" name="end_date"
                        id="for_end_date" value="" required>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="for_fundament">Fundamento</label>
                    <select name="fundament" id="for_fundament" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="replacement" {{ ($requestReplacementStaff->fundament == 'replacement')?'selected':'' }}>Reemplazo o suplencia</option>
                        <option value="quit" {{ ($requestReplacementStaff->fundament == 'quit')?'selected':'' }}>Renuncia</option>
                        <option value="allowance without payment" {{ ($requestReplacementStaff->fundament == 'allowance without payment')?'selected':'' }}>Permiso sin goce de sueldo</option>
                        <option value="regularization work position" {{ ($requestReplacementStaff->fundament == 'regularization work position')?'selected':'' }}>Regulación de cargos</option>
                        <option value="expand work position" {{ ($requestReplacementStaff->fundament == 'expand work position')?'selected':'' }}>Cargo expansión</option>
                        <option value="vacations" {{ ($requestReplacementStaff->fundament == 'vacations')?'selected':'' }}>Feriado legal</option>
                        <option value="other" {{ ($requestReplacementStaff->fundament == 'other')?'selected':'' }}>Otro</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_name_to_replace">&nbsp;</label>
                    <input type="text" class="form-control" name="name_to_replace"
                        id="for_name_to_replace" placeholder="Nombre de Reemplazo"
                        value="{{ $requestReplacementStaff->name_to_replace }}">
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_other_fundament">&nbsp;</label>
                    <input type="text" class="form-control" name="other_fundament"
                        id="for_other_fundament" placeholder="Otro fundamento..."
                        value="{{ $requestReplacementStaff->other_fundament }}">
                </fieldset>
            </div>

            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>

        </form>
    </div>
</div> -->

<div class="card">
    <div class="card-header">
        Solicitud Contratación de Personal
    </div>
    <div class="card-body">

        <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.store_extension', $requestReplacementStaff) }}" enctype="multipart/form-data"/>
            @csrf
            @method('POST')

            <div class="form-row">
                <fieldset class="form-group col-4">
                    <label for="for_name">Nombre de Cargo</label>
                    <input type="text" class="form-control" name="name" value="Extensión {{ $requestReplacementStaff->name }}"
                        id="for_name" required>
                </fieldset>

                @livewire('replacement-staff.show-profile-request', ['requestReplacementStaff' => $requestReplacementStaff ])

                <fieldset class="form-group col-2">
                    <label for="for_start_date">Desde</label>
                    <input type="date" class="form-control" name="start_date" value="{{ $requestReplacementStaff->end_date->format('Y-m-d') }}"
                        id="for_start_date" required>
                </fieldset>

                <fieldset class="form-group col-2">
                    <label for="for_end_date">Hasta</label>
                    <input type="date" class="form-control" name="end_date"
                        id="for_end_date" required>
                </fieldset>
            </div>

            <div class="form-row">
                @livewire('replacement-staff.show-legal-quality-request', ['requestReplacementStaff' => $requestReplacementStaff ])
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
                    <input type="text" class="form-control" name="other_work_day"
                        id="for_other_work_day" placeholder="Otro">
                </fieldset>

                <fieldset class="form-group col-2">
                    <label for="for_charges_number">Nº Cargos</label>
                    <input type="number" class="form-control" name="charges_number" value="{{ $requestReplacementStaff->charges_number }}"
                        id="for_charges_number" required>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-md-6">
                    <div class="mb-3">
                      <label for="for_job_profile_file" class="form-label">Perfil de Cargo (Opcional)</label>
                      <input class="form-control" type="file" name="job_profile_file"
                          accept="application/pdf"
                    </div>
                </fieldset>

                <fieldset class="form-group col-md-6">
                    <div class="mb-3">
                      <label for="for_request_verification_file" class="form-label">Correo (Verificación Solicitud)</label>
                      <input class="form-control" type="file" name="request_verification_file"
                          accept="application/pdf" required>
                    </div>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-md-6">
            			<label for="for_ou_of_performance_id">Unidad Organizacional</label>
            			<select class="form-control selectpicker" data-live-search="true" id="for_ou_of_performance_id" name="ou_of_performance_id" data-size="5" required>
            			@foreach($ouRoots as $ouRoot)
            				<option value="{{ $ouRoot->id }}" {{ ($requestReplacementStaff->organizationalUnit == $ouRoot)?'selected':'' }}>
            				{{ $ouRoot->name }} ({{$ouRoot->establishment->name}})
            				</option>
            				@foreach($ouRoot->childs as $child_level_1)
            					<option value="{{ $child_level_1->id }}" {{ ($requestReplacementStaff->organizationalUnit == $child_level_1)?'selected':'' }}>
            					&nbsp;&nbsp;&nbsp;
            					{{ $child_level_1->name }} ({{ $child_level_1->establishment->name }})
            					</option>
            					@foreach($child_level_1->childs as $child_level_2)
            						<option value="{{ $child_level_2->id }}" {{ ($requestReplacementStaff->organizationalUnit == $child_level_2)?'selected':'' }}>
            						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            						{{ $child_level_2->name }} ({{ $child_level_2->establishment->name }})
            						</option>
            						@foreach($child_level_2->childs as $child_level_3)
            							<option value="{{ $child_level_3->id }}" {{ ($requestReplacementStaff->organizationalUnit == $child_level_3)?'selected':'' }}>
            								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            								{{ $child_level_3->name }} ({{ $child_level_3->establishment->name }})
            							</option>
            							@foreach($child_level_3->childs as $child_level_4)
            							<option value="{{ $child_level_4->id }}" {{ ($requestReplacementStaff->organizationalUnit == $child_level_4)?'selected':'' }}>
            	                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	                            {{ $child_level_4->name }} ({{ $child_level_4->establishment->name }})
            	                        </option>
            							@endforeach
            						@endforeach
            					@endforeach
            				@endforeach
            			@endforeach

            			</select>
            		</fieldset>
            </div>

            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
        </form>
    </div>
</div>

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
