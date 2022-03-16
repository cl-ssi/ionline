<!-- Modal -->
<div class="modal fade" id="exampleModal-to-change-selected-applicant-{{ $applicant->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Postulante Seleccionado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Postulante(s) a cargo</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead class="text-center small">
                            <tr>
                              <th style="width: 15%">Nombre</th>
                              <th style="width: 18%">Calificación Evaluación Psicolaboral</th>
                              <th style="width: 18%">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                              <th style="width: 22%">Observaciones</th>
                              @if($technicalEvaluation->requestReplacementStaff->assignEvaluations->last()->to_user_id == Auth::user()->id ||
                                  Auth::user()->hasRole('Replacement Staff: admin'))
                              <th>Ingreso Efectivo</th>
                              <th>Fin</th>
                              @endif
                            </tr>
                        </thead>
                        <tbody class="small">
                            <tr class="{{ ($applicant->selected == 1 && $applicant->desist == NULL)?'table-success':''}}">
                                <td>
                                  <a href="{{ route('replacement_staff.show_replacement_staff', $applicant->replacementStaff) }}"
                                    target="_blank">{{ $applicant->replacementStaff->FullName }}
                                  <a>
                                  <br>
                                  @if($applicant->selected == 1 && $applicant->desist == NULL)
                                    <span class="badge bg-success">Seleccionado</span>
                                  @endif
                                  @if($applicant->desist == 1)
                                    <span class="badge bg-danger">Desiste Selección</span>
                                  @endif
                                </td>
                                <td class="text-center">{{ $applicant->psycholabor_evaluation_score }} <br> {{ $applicant->PsyEvaScore }}</td>
                                <td class="text-center">{{ $applicant->technical_evaluation_score }} <br> {{ $applicant->TechEvaScore }}</td>
                                <td>{{ $applicant->observations }}</td>
                                <td class="text-center">{{ ($applicant->start_date) ? $applicant->start_date->format('d-m-Y') : '' }}</td>
                                <td class="text-center">{{ ($applicant->end_date) ? $applicant->end_date->format('d-m-Y') : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="row"> -->
                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.decline_selected_applicant', $applicant) }}">
                                @csrf
                                @method('POST')
                                <div class="form-row">
                                    <fieldset class="form-group col-12">
                                        <label for="for_reason" >Motivo</label>
                                        <select name="reason" id="for_reason" class="form-control" onchange="changeSelectReason()" required>
                                            <option value="">Seleccione...</option>
                                            <option value="renuncia a reemplazo">Renuncia a reemplazo (Posterior ingreso)</option>
                                            <option value="rechazo oferta laboral">Rechazo oferta laboral (Previo ingreso)</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="form-row">
                                    <fieldset class="form-group col-12">
                                        <label for="for_observation">Observación</label>
                                        <textarea class="form-control" name="observation" id="for_observation" rows="2" required></textarea>
                                    </fieldset>
                                </div>
                                <div class="form-row">
                                    <fieldset class="form-group col-6">
                                        <label for="for_start_date">Desde</label>
                                        <input type="date" class="form-control" name="start_date"
                                            id="for_start_date" value="{{ $applicant->start_date->format('Y-m-d')  }}" required>
                                    </fieldset>
                                    <fieldset class="form-group col-6">
                                        <label for="for_end_date">Hasta</label>
                                        <input type="date" class="form-control" name="end_date"
                                            id="for_end_date" value="{{ $applicant->end_date->format('Y-m-d')  }}" required>
                                    </fieldset>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Guardar</button>
                            </form>
                        <!-- </div> -->
                    </div>
                </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
