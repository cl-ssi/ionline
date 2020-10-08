<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Asignar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" >
                <div class="modal-body">
                    {{ method_field('POST') }} {{ csrf_field() }}
                    <input type="hidden" class="form-control" name="professional_id">
                    <input type="hidden" class="form-control" name="programming_id">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Valor Hora:</label>
                        <input type="text" class="form-control" name="value">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Asignar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
