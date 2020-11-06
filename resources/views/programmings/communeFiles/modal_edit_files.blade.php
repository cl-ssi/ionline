<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Adjuntar Documentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="communefile_id">
                    <input type="hidden" class="form-control" name="date">
                    <input type="hidden" class="form-control" name="user">

                    <div class="form-row">
                        <fieldset class="form-group col-12">
                            <label for="for" class="col-form-label">Archivo - Diagnostico</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="forfile" name="file_a">
                              <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-12">
                            <label for="for" class="col-form-label">Archivo - Matriz de Cuidado</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="forfile" name="file_b">
                              <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-row">
                        <fieldset class="form-group col-12">
                            <label for="for" class="col-form-label">Archivo</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="forfile" name="file_c">
                              <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
                            </div>
                        </fieldset>
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
