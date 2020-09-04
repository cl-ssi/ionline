<div class="modal fade" id="editModalDateStageAddendum" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Fechas Addendum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="agreement_id">
                    <input type="hidden" class="form-control" name="date">
                    <input type="hidden" class="form-control" name="dateEnd">
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
                        <label for="date_addendum" class="col-form-label">Fecha Entrada Addendum:</label>
                        <input type="date" class="form-control" name="date_addendum">
                    </div>
                    <div class="form-group">
                        <label for="date_end_addendum" class="col-form-label">Fecha Salida Addendum:</label>
                        <input type="date" class="form-control" name="dateEnd_addendum">
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
