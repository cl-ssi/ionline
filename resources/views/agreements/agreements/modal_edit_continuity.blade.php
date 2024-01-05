<div class="modal fade" id="editModalContinuityResol-{{$continuity->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Resolución</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit-{{$continuity->id}}" action="{{ route('agreements.continuity.update', $continuity )}}" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha</label>
                        <input type="date" class="form-control" name="date" value="{{$continuity->date ? $continuity->date->format('Y-m-d') : ''}}" required>
                    </div>

                    <div class="form-group">
                        <label for="forreferente">Referente</label>
                        @livewire('search-select-user', [
                            'user' => $continuity->referrer,
                            'required' => 'required',
                            'selected_id' => 'referrer_id',
                        ])
                    </div>

                    <div class="form-group">
                        <label for="forrepresentative">Director/a a cargo</label>
                        <select name="director_signer_id" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($signers as $signer)
                            <option value="{{$signer->id}}" {{$signer->id == $continuity->director_signer_id ? 'selected' : ''}}>{{ Str::limit($signer->appellative.' '.$signer->user->fullName.', '.$signer->decree, 155) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="col-form-label">Monto total</label>
                        <input type="number" class="form-control" name="amount" value="{{$continuity->amount}}" required>
                    </div>

                    <div class="form-group">
                        <label for="for">Archivo Resolucion Final formato Wordx 
                            @if($continuity->file != null)  
                                <a class="text-info" href="{{ route('agreements.continuity.download', $continuity) }}" target="_blank">
                                    <i class="fas fa-paperclip"></i> adjunto
                                </a>
                            @endif
                        </label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="forfile" name="file" placeholder="Seleccionar Archivo" accept=".doc, .docx">
                          <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="number" class="col-form-label">Fecha Resolución Exenta de la Resolución de continuidad</label>
                        <input type="date" class="form-control" name="res_date" value="{{ $continuity->res_date ? $continuity->res_date->format('Y-m-d') : '' }}">
                    </div>

                    <div class="form-group">
                        <label for="number" class="col-form-label">Número Resolución Exenta de la Resolución de continuidad</label>
                        <input type="number" class="form-control" name="res_number" value="{{ $continuity->res_number }}">
                    </div>

                    <div class="form-group">
                        <label for="for">Archivo Resolución Continuidad Final PDF SST
                            @if($continuity->res_file)
                             <a class="text-info" href="{{ route('agreements.continuity.downloadRes', $continuity) }}" target="_blank">
                                <i class="fas fa-paperclip"></i> adjunto
                            </a>
                            @endif
                        </label>
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
