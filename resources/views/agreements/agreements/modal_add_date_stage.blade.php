
<div class="modal fade" id="addModalDateStage" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Agregar Fechas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ method_field('POST') }} {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="agreement_id">
                    <input type="hidden" name="group">
                    <input type="hidden" name="type">
                    
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha Entrada:</label>
                        <input type="date" class="form-control" name="date" required="required">
                    </div>
                    <div class="form-group">
                        <label for="date_end" class="col-form-label">Fecha Salida:</label>
                        <input type="date" class="form-control" name="dateEnd">
                    </div>
                    <div class="form-group">
                        <label for="date_end" class="col-form-label">Comentario:</label>
                    <input type="text" class="form-control" id="forObservation"
                        placeholder="..." name="observation">
                    </div>

                    <!--<div class="form-group">
                        <label for="for">Archivo</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="forfile" name="file" placeholder="Seleccionar Archivo">
                          <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
                        </div>
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
