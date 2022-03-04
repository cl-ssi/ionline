<div class="modal fade" id="editModalAddendum" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Addendum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="forreferente">Referente</label>
                        <!-- <input type="text" name="referente" class="form-control" id="forreferente" value="{{ $agreement->referente }}" > -->
                        <select name="referrer_id" class="form-control selectpicker" data-live-search="true" title="Seleccione referente" required>
                            @foreach($referrers as $referrer)
                            <option value="{{$referrer->id}}">{{$referrer->fullName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="forrepresentative">Director/a a cargo</label>
                        <select name="director_signer_id" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($signers as $signer)
                            <option value="{{$signer->id}}">{{ Str::limit($signer->appellative.' '.$signer->user->fullName.', '.$signer->decree, 155) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="forrepresentative">Representante alcalde</label>
                        <select id="representative" class="selectpicker" name="representative" title="Seleccione..." data-width="100%" required>
                            <option value="{{ $municipality->name_representative }}">{{ $municipality->appellative_representative }} {{ $municipality->name_representative }}, {{ $municipality->decree_representative }}</option>
                            @if($municipality->name_representative_surrogate != null) <option value="{{ $municipality->name_representative_surrogate }}">{{ $municipality->appellative_representative_surrogate }} {{ $municipality->name_representative_surrogate }}, {{ $municipality->decree_representative_surrogate }}</option> @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="for">Archivo Addendum Final formato Wordx</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="forfile" name="file" placeholder="Seleccionar Archivo" accept=".doc, .docx">
                          <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="number" class="col-form-label">Fecha Resolución Exenta del Addendum</label>
                        <input type="date" class="form-control" name="res_date">
                    </div>

                    <div class="form-group">
                        <label for="number" class="col-form-label">Número Resolución Exenta del Addendum</label>
                        <input type="number" class="form-control" name="res_number">
                    </div>

                    <div class="form-group">
                        <label for="for">Archivo Resolución Final PDF SSI</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="forfile" name="res_file" placeholder="Seleccionar Archivo" accept="application/pdf">
                          <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
                        </div>
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
