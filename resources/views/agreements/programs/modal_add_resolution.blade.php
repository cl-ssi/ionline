<div class="modal fade" id="addModalProgramResolution" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Nueva Resolución</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-add" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ csrf_field() }}

                    <input type="hidden" name="program_id" value="{{$program->id}}">
                    
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha Resolución</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="forreferente">Referente</label>
                        <select name="referrer_id" class="form-control selectpicker" data-live-search="true" title="Seleccione referente" required>
                            @foreach($referrers as $referrer)
                            <option value="{{$referrer->id}}">{{$referrer->fullName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fordirector">Director/a a cargo</label>
                        <select name="director_signer_id" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($signers as $signer)
                            <option value="{{$signer->id}}">{{$signer->appellative}} {{$signer->user->fullName}}, {{$signer->decree}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="forestablishment">Establecimiento</label>
                        @php($establishments = array('Servicio de Salud Iquique', 'Hospital Dr. Ernesto Torres G.', 'CGU. Hector Reyno'))
                        <select name="establishment" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($establishments as $establishment)
                            <option value="{{$establishment}}">{{$establishment}}</option>
                            @endforeach
                        </select>
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
