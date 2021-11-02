<div class="modal fade" id="addModalAmount" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Agregar monto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-add" >
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="foritem">Componente</label>
                        <select name="program_component_id" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($program_resolution->program->components as $component)
                            <option value="{{$component->id}}">{{$component->name}}</option>
                            @endforeach
                        </select>
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
