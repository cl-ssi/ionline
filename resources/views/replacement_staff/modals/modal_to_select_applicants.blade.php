<!-- Modal -->
<div class="modal fade" id="exampleModal-to-select-applicants" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selección de Postulante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Postulantes a cargo(s)</h6>
                <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.update_to_select', $applicant) }}">
                @csrf
                @method('PUT')

                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead class="text-center small">
                            <tr>
                              <th style="width: 22%">Nombre</th>
                              <th style="width: 22%">Calificación Evaluación Psicolaboral</th>
                              <th style="width: 22%">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                              <th style="width: 22%">Observaciones</th>
                              <th style="width: 2%"></th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach($technicalEvaluation->applicants->sortByDesc('score') as $applicant)
                            <tr class="{{ ($applicant->selected == 1 && $applicant->desist == NULL)?'table-success':''}}">
                                <td>
                                    {{ $applicant->replacementStaff->FullName }}
                                    <br>
                                    @if($applicant->selected == 1 && $applicant->desist == NULL)
                                      <span class="badge bg-success">Seleccionado</span>
                                    @endif
                                    @if($applicant->desist == 1)
                                      <span class="badge bg-danger">
                                        @if($applicant->reason == 'renuncia a reemplazo')
                                          Renuncia a reemplazo (Posterior ingreso)
                                        @endif
                                        @if($applicant->reason == 'rechazo oferta laboral')
                                          Rechazo oferta laboral (Previo ingreso)
                                        @endif
                                      </span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $applicant->psycholabor_evaluation_score }} <br> {{ $applicant->PsyEvaScore }}</td>
                                <td class="text-center">{{ $applicant->technical_evaluation_score }} <br> {{ $applicant->TechEvaScore }}</td>
                                <td>{{ $applicant->observations }}</td>
                                <td>
                                  @if($applicant->desist == NULL)
                                  <fieldset class="form-group">
                                      <div class="form-check">
                                          <input class="form-check-input" type="checkbox" name="applicant_id[]" onclick="myFunction()" id="for_applicant_id"
                                            value="{{ $applicant->id }}">
                                      </div>
                                  </fieldset>
                                  @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card">
                  <div class="card-body">
                    <h6>Fecha Efectiva de Ingreso</h6>
                    <br>
                    <div class="form-row">
                        <fieldset class="form-group col-3">
                            <label for="for_start_date">Desde</label>
                            <input type="date" class="form-control" name="start_date"
                                  id="for_start_date" value="{{ $technicalEvaluation->requestReplacementStaff->start_date->format('Y-m-d')  }}" required>
                        </fieldset>
                        <fieldset class="form-group col-3">
                            <label for="for_end_date">Hasta</label>
                            <input type="date" class="form-control" name="end_date"
                                id="for_end_date" value="{{ $technicalEvaluation->requestReplacementStaff->end_date->format('Y-m-d')  }}" required>
                        </fieldset>
                        <!-- <fieldset class="form-group col-sm-6">
                            <label for="for_place_of_performance">Lugar de Desempeño</label>
                            <input type="text" class="form-control" name="place_of_performance" id="for_replace_of_performance">
                        </fieldset> -->
                        <fieldset class="form-group col-md-6">
                    			<label for="for_ou_of_performance_id">Unidad Organizacional</label>
                    			<select class="form-control selectpicker" data-live-search="true" id="for_ou_of_performance_id" name="ou_of_performance_id" data-size="5" required>
                    			@foreach($ouRoots as $ouRoot)
                    				<option value="{{ $ouRoot->id }}" {{ ($technicalEvaluation->requestReplacementStaff->ouPerformance == $ouRoot)?'selected':'' }}>
                    				{{ $ouRoot->name }} ({{$ouRoot->establishment->name}})
                    				</option>
                    				@foreach($ouRoot->childs as $child_level_1)
                    					<option value="{{ $child_level_1->id }}" {{ ($technicalEvaluation->requestReplacementStaff->ouPerformance == $child_level_1)?'selected':'' }}>
                    					&nbsp;&nbsp;&nbsp;
                    					{{ $child_level_1->name }} ({{ $child_level_1->establishment->name }})
                    					</option>
                    					@foreach($child_level_1->childs as $child_level_2)
                    						<option value="{{ $child_level_2->id }}" {{ ($technicalEvaluation->requestReplacementStaff->ouPerformance == $child_level_2)?'selected':'' }}>
                    						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    						{{ $child_level_2->name }} ({{ $child_level_2->establishment->name }})
                    						</option>
                    						@foreach($child_level_2->childs as $child_level_3)
                    							<option value="{{ $child_level_3->id }}" {{ ($technicalEvaluation->requestReplacementStaff->ouPerformance == $child_level_3)?'selected':'' }}>
                    								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    								{{ $child_level_3->name }} ({{ $child_level_3->establishment->name }})
                    							</option>
                    							@foreach($child_level_3->childs as $child_level_4)
                    							<option value="{{ $child_level_4->id }}" {{ ($technicalEvaluation->requestReplacementStaff->ouPerformance == $child_level_4)?'selected':'' }}>
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
                    <div class="form-row">
                        <fieldset class="form-group col">
                            <label for="for_replacement_reason">Motivo de Reemplazo</label>
                            <input type="text" class="form-control" name="replacement_reason" id="for_replacement_reason" value="{{ $technicalEvaluation->requestReplacementStaff->fundamentManage->NameValue }}">
                        </fieldset>
                    </div>

                    <button type="submit" class="btn btn-primary float-right" id="save_btn"
                        onclick="return confirm('¿Está seguro que desea terminar el proceso de selección?')">
                        <i class="fas fa-save"></i> Guardar</button>
                  </div>
                </div>

                </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

document.getElementById("save_btn").disabled = true;

function myFunction() {
  // Get the checkbox
  var checkBox = document.getElementById("for_applicant_id");

  // If the checkbox is checked, display the output text
  if (document.querySelectorAll('input[type="checkbox"]:checked').length > 0){
    document.getElementById("save_btn").disabled = false;
  } else {
    document.getElementById("save_btn").disabled = true;
  }
}
</script>
