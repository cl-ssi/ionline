<!-- Modal -->
<div class="modal fade" id="exampleModal-to-evaluate-applicant-{{ $applicant->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="text" class="form-control" value="{{ $applicant->replacementStaff->run }}" readonly>
                    </fieldset>
                    <fieldset class="form-group col-sm-1">
                        <label for="for_dv">DV</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacementStaff->dv }}" readonly>
                    </fieldset>
                    <fieldset class="form-group col-3">
                        <label for="for_name">Nombres</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacementStaff->name }}" readonly>
                    </fieldset>
                    <fieldset class="form-group col-3">
                        <label for="for_name">Apellido Paterno</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacementStaff->fathers_family }}" readonly>
                    </fieldset>
                    <fieldset class="form-group col-3">
                        <label for="for_name">Apellido Materno</label>
                        <input type="text" class="form-control" value="{{ $applicant->replacementStaff->mothers_family }}" readonly>
                    </fieldset>
                </div>
                <hr>
                <br>
                <h5>Calificación de Postulante</h5>
                <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.update', $applicant) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <fieldset class="form-group col-sm-2">
                            <label for="for_psycholabor_evaluation_score">Evaluación Psicolaboral</label>
                            <input type="number" class="form-control" name="psycholabor_evaluation_score" id="for_psycholabor_evaluation_score" min="1" max="100"
                                value="{{ $applicant->psycholabor_evaluation_score }}" >
                        </fieldset>
                        <fieldset class="form-group col-sm-4">
                            <label for="for_technical_evaluation_score">Evaluación técnica y/o de Apreciación Global</label>
                            <input type="number" class="form-control" name="technical_evaluation_score" id="for_technical_evaluation_score" min="1" max="100"
                                value="{{ $applicant->technical_evaluation_score }}" >
                        </fieldset>
                        <fieldset class="form-group col-sm-6">
                            <label for="for_observations">Observaciones</label>
                            <input type="text" class="form-control" name="observations" id="for_observations" value="{{ $applicant->observations }}">
                        </fieldset>
                    </div>

                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
                </form>

                <br><br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
