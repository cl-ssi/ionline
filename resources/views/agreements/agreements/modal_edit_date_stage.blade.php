<div class="modal fade" id="editModalDateStage" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Fechas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="agreement_id">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                             <label for="type" class="col-form-label">Etapa:</label>
                             <input type="text" class="form-control" name="type" disabled>
                        </div>
                        <!--<fieldset class="form-group col-6">
                            <label for="for" class="col-form-label">Archivo</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="forfile" name="file">
                              <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
                              <small class="form-text text-muted">* Adjuntar archivo correspondiente.</small>
                            </div>
                        </fieldset>-->
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha Entrada:</label>
                        <input type="date" class="form-control" name="date">
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

                    <div class="form-group">
                         <a class="d-block text-dark text-decoration-none" id="urlfile"  href="#">
                            <div class="p-3 py-4 mb-2 bg-light text-center rounded">
                                <i id="iconfile" class="" style='font-size:50px'></i>
                            </div>
                        </a>
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
