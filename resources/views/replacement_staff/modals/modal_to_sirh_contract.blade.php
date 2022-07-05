<!-- Modal -->
<div class="modal fade" id="exampleModal-to-sirh-contract-{{ $applicant->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-file-signature"></i> Ingrese Fecha de Contrato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.applicant.update', $applicant) }}">
              @csrf
              @method('PUT')
              <div class="form-row">
                  <fieldset class="form-group col-sm">
                      <input type="date" class="form-control" name="sirh_contract" id="for_sirh_contract" required>
                  </fieldset>
              </div>

              <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
