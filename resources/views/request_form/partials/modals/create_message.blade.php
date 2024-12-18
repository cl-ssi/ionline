<!-- Modal -->
<div class="modal fade" id="exampleModal-{{ $requestForm->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-comment"></i> Agregar Mensaje</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p class="text-left"><i class="fas fa-user"></i> {{ auth()->user()->fullName }}</p>
          <form method="POST" class="form-horizontal" action="{{ route('request_forms.message.store', [
            'requestForm' => $requestForm,
            'eventType' => $eventType,
            'from' => $from]) }}" enctype="multipart/form-data">
              @csrf
              @method('POST')
              <div class="form-row">
                  <fieldset class="form-group col-sm">
                      <label for="for_message" class="form-label"><i class="fas fa-comment"></i>  Observaciones</label>
                      <textarea class="form-control" name="message" id="for_message" rows="3" required></textarea>
                  </fieldset>
              </div>
              <div class="form-row">
                  <fieldset class="form-group col-sm">
                      <label for="for_file">Adjuntar archivo</label>
                      <input type="file" class="form-control-file" id="for_file" name="file" accept="application/pdf">
                  </fieldset>
              </div>

              <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Guardar</button>

          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
