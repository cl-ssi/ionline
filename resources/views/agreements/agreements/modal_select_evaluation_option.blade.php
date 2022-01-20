
<div class="modal fade" id="selectEvalOption" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Opciones de evaluación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="GET" id="form-edit">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <!-- <label for="for_name">Nombre</label> -->
                        <select name="eval_option" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <option value="3">Única evaluacion técnica</option>
                            <option value="1">2 evaluaciones técnicas</option>
                            <option value="2">3 evaluaciones técnicas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="SubmitSignerSelected">Previsualizar convenio</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
