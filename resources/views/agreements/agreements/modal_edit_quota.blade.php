<div class="modal fade" id="editModalQuota" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar cuota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" >
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    <div class="form-group">
                        <label for="description" class="col-form-label">Descripción:</label>
                        <input type="text" class="form-control" name="description">
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-form-label">Monto:</label>
                        <input type="text" class="form-control" name="amount">
                    </div>
                    <div class="form-group">
                        <label for="transfer_at" class="col-form-label">Fecha Transferencia:</label>
                        <input type="date" class="form-control" name="transfer_at">
                    </div>
                    <div class="form-group">
                        <label for="voucher_number" class="col-form-label">Comprobante:</label>
                        <input type="text" class="form-control" name="voucher_number">
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
