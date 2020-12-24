<div class="modal fade" id="updateModalConfirm" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">¿Confirmar Rectificación?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="review_id">


                    <div class="form-row">
                        <fieldset class="form-group col-12">
                            <label for="forprogram">¿Se Acepta?</label>
                            <select name="answer" id="answer"  class="form-control">
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="REGULAR">REGULAR</option>
                                
                            </select>
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
