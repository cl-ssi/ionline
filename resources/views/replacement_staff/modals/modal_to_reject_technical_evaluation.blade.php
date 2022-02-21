<!-- Modal -->
<div class="modal fade" id="exampleModal-reject-{{$technicalEvaluation->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Finalizar Proceso Selección</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="POST" class="form-horizontal"
            action="{{ route('replacement_staff.request.technical_evaluation.finalize_selection_process', $technicalEvaluation) }}"/>
              @csrf
              @method('POST')
              <fieldset class="form-group col mt">
                  <label for="for_reason">Motivo</label>
                  <select name="reason" class="form-control" required>
                      <option value="">Seleccione</option>
                      @if($technicalEvaluation->applicants->count() == 0)
                      <option value="falta oferta laboral">Falta de oferta laboral</option>
                      @endif
                      @if($technicalEvaluation->applicants->count() > 0)
                      <option value="rechazo oferta laboral">Rechazo de oferta laboral</option>
                      @endif
                  </select>
              </fieldset>

              <fieldset class="form-group col mt">
                  <label for="for_observation">Observación</label>
                  <textarea class="form-control" name="observation" id="for_observation" rows="3" required></textarea>
              </fieldset>

              <fieldset class="form-group col mt">
                      <label for="for_button"><br></label>
                      <button class="btn btn-danger btn-sm float-right"><i class="fas fa-window-close"></i> Finalizar Proceso Selección</button>
              </fieldset>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
