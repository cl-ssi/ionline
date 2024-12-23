<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Registro Teléfonico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body">
              <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.contact_record.store', $staff) }}" enctype="multipart/form-data">
                  @csrf
                  @method('POST')

                  <div class="form-row">
                      <fieldset class="form-group col">
                          <label for="for_replacement_staff_id">Nombre de Postulante</label>
                          <input type="text" class="form-control" name="replacement_staff_id" id="for_replacement_staff_id" value="{{ $staff->fullName }}" readonly>
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col">
                          <label for="for_contact_date">Fecha / Hora</label>
                          <input type="datetime-local" class="form-control" id="for_contact_date"
                              name="contact_date" required>
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col">
                          <label for="for_gender" >Tipo de Contacto</label>
                          <select name="type" id="for_type" class="form-control" required>
                              <option value="">Seleccione...</option>
                              <option value="email">Correo Electrónico</option>
                              <option value="telephone">Telefónico</option>
                              <option value="other">Otro</option>
                          </select>
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-sm">
                          <label for="for_observation" class="form-label">Observación</label>
                          <textarea name="observation" class="form-control form-control-sm" rows="3"></textarea>
                      </fieldset>
                  </div>

                  <button type="submit" class="btn btn-primary btn-sm float-right" id="save_btn"><i class="fas fa-save"></i> Guardar</button>

              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
    </div>
</div>
