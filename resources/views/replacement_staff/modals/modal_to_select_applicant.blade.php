<!-- Modal -->
<div class="modal fade" id="exampleModal-applicant-{{ $applicant->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selección de Postulante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Datos Personales</h5>

                <div class="form-row">
                    <fieldset class="form-group col-sm-2">
                        <label for="for_run">RUT</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacement_staff->run }}" readonly>
                    </fieldset>
                    <fieldset class="form-group col-sm-1">
                        <label for="for_dv">DV</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacement_staff->dv }}" readonly>
                    </fieldset>
                    <fieldset class="form-group col-3">
                        <label for="for_name">Nombres</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacement_staff->name }}" readonly>
                    </fieldset>
                    <fieldset class="form-group col-3">
                        <label for="for_name">Apellido Paterno</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacement_staff->fathers_family }}" readonly>
                    </fieldset>
                    <fieldset class="form-group col-3">
                        <label for="for_name">Apellido Materno</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacement_staff->mothers_family }}" readonly>
                    </fieldset>
                </div>
                <hr>
                <br>
                <h5>Calificación de Postulante</h5>
                <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.update', $applicant) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <fieldset class="form-group col-sm-3">
                            <label for="for_score">Calificación</label>
                            <input type="number" class="form-control" name="score" id="for_score" min="1" max="100" value="{{ $applicant->score }}">
                        </fieldset>
                        <fieldset class="form-group col-sm-9">
                            <label for="for_observations">Observaciones</label>
                            <input type="text" class="form-control" name="observations" id="for_observations" value="{{ $applicant->observations }}">
                        </fieldset>
                    </div>

                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
                </form>
                <br><br>
                <hr>
                <br>
                <h5>Seleccionar Postulante</h5>
                @if($applicant->score != NULL)
                <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.update_to_select', $applicant) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <fieldset class="form-group col-3">
                            <label for="for_start_date">Desde</label>
                            <input type="date" class="form-control" name="start_date"
                              id="for_start_date" required>
                        </fieldset>
                        <fieldset class="form-group col-3">
                            <label for="for_end_date">Hasta</label>
                            <input type="date" class="form-control" name="end_date"
                              id="for_end_date" required>
                        </fieldset>
                        <fieldset class="form-group col-sm-3">
                            <label for="for_name_to_replace">A Quien Replaza</label>
                            <input type="text" class="form-control" name="name_to_replace" id="for_name_to_replace" value="{{ $applicant->name_to_replace }}">
                        </fieldset>
                        <fieldset class="form-group col-sm-3">
                            <label for="for_replacement_reason">Motivo de Reemplazo</label>
                            <input type="text" class="form-control" name="replacement_reason" id="for_replacement_reason" value="{{ $applicant->replacement_reason }}">
                        </fieldset>
                    </div>

                    <div class="form-row">
                        <fieldset class="form-group col-sm-3">
                            <label for="for_place_of_performance">Lugar de Desempeño</label>
                            <input type="text" class="form-control" name="place_of_performance" id="for_rplace_of_performance" value="{{ $applicant->place_of_performance }}">
                        </fieldset>
                    </div>

                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
                </form>
                @else
                    <br>
                    <div class="alert alert-secondary" role="alert">
                        Estimado Usuario, antes de seleccionar al postulante, primero debe registrar su calificación.
                    </div>
                @endif
                <br><br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
