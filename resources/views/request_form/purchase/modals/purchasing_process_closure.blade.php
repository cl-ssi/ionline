<!-- Modal -->
<div class="modal fade" id="processClosure" tabindex="-1" aria-labelledby="processClosureLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="processClosureLabel">Cierre de proceso de compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="new-budget-form" action="{{ route('request_forms.supply.close_purchasing_process', $requestForm->id )}}">
                    @csrf
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label for="for_status">Estado:</label>
                            <select name="status" class="form-control form-control-sm" required>
                                <option value="">Seleccione...</option>
                                <option value="finished">Terminado</option>
                                <option value="canceled">Anulado</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label for="for_observation">Observación (opcional):</label>
                            <textarea name="observation" class="form-control form-control-sm" rows="3" autofocus></textarea>
                        </fieldset>
                    </div>
                    <button type="submit" class="btn btn-primary float-right btn-sm">Finalizar</button>
                </form>
            </div>
        </div>
    </div>
</div>