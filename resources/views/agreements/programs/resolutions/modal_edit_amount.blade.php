<div class="modal fade" id="editModalAmount" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar componente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" >
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name" class="col-form-label">Componente:</label>
                        <input type="text" class="form-control" name="name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Subtitulo:</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="subtitle" id="subtitle21" value="21" required>
                            <label class="form-check-label" for="subtitle21">21 Honorarios</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="subtitle" id="subtitle22" value="22">
                            <label class="form-check-label" for="subtitle22">22 Compra Insumos</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Monto:</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
