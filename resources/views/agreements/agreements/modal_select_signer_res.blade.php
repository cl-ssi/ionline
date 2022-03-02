
<div class="modal fade" id="selectSignerRes" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Seleccione firmante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit">
                <div class="modal-body">
                    @csrf
                    <!-- <input type="hidden" class="form-control" name="agreement_id"> -->
                    <div class="form-group">
                        <!-- <label for="for_name">Nombre</label> -->
                        <select name="signer_id" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($signers as $signer)
                            <option value="{{$signer->id}}">{{ Str::limit($signer->appellative.' '.$signer->user->fullName.', '.$signer->decree, 155) }}</option>
                            @endforeach
                        </select>
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
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="SubmitSignerSelected">Previsualizar resolución</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
