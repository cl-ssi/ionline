<!-- Modal -->
<div class="modal fade" id="exampleModal-assign-{{$requestReplacementStaff->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignar requerimientos a funcionario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.store', $requestReplacementStaff) }}">
              @csrf
              @method('POST')
              <div class="form-row">
                  <fieldset class="form-group col">
                      <label for="for_to_user_id">Funcionario</label>
                      <select name="to_user_id" id="for_to_user_id" class="form-control" required>
                          <option value="">Seleccione...</option>
                          @foreach($users_rys as $user_rys)
                              <option value="{{ $user_rys->id }}">{{ $user_rys->FullName }}</option>
                          @endforeach
                      </select>
                  </fieldset>
              </div>
              <div class="form-row">
                  <fieldset class="form-group col">
                      <label for="for_observation" class="form-label">Observaciones</label>
                      <textarea class="form-control" name="observation" id="for_observation" rows="3" required></textarea>
                  </fieldset>
              </div>

              <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>

          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
