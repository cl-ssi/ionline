<div class="modal fade" id="editModalAddendum-{{$addendum->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Addendum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit-{{$addendum->id}}" action="{{ route('agreements.addendums.update', $addendum )}}" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha</label>
                        <input type="date" class="form-control" name="date" value="{{$addendum->date ? $addendum->date->format('Y-m-d') : ''}}" required>
                    </div>

                    <div class="form-group">
                        <label for="forreferente">Referente</label>
                        @livewire('search-select-user', [
                            'user' => $addendum->referrer,
                            'required' => 'required',
                            'selected_id' => 'referrer_id',
                        ])
                    </div>

                    <div class="form-group">
                        <label for="forrepresentative">Director/a a cargo</label>
                        <select name="director_signer_id" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($signers as $signer)
                            <option value="{{$signer->id}}" {{$signer->id == $addendum->director_signer_id ? 'selected' : ''}}>{{ Str::limit($signer->appellative.' '.$signer->user->fullName.', '.$signer->decree, 155) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="forrepresentative">Representante alcalde</label>
                        <select id="representative" class="selectpicker" name="representative" title="Seleccione..." data-width="100%" required>
                            <option value="{{ $municipality->name_representative }}" {{$municipality->name_representative == $addendum->representative ? 'selected': ''}}>{{ $municipality->appellative_representative }} {{ $municipality->name_representative }}, {{ $municipality->decree_representative }}</option>
                            @if($municipality->name_representative_surrogate != null) <option value="{{ $municipality->name_representative_surrogate }}" {{$municipality->name_representative_surrogate == $addendum->representative ? 'selected': ''}}>{{ $municipality->appellative_representative_surrogate }} {{ $municipality->name_representative_surrogate }}, {{ $municipality->decree_representative_surrogate }}</option> @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="for">Archivo Addendum Final formato Wordx 
                            @if($addendum->file != null)  
                                <a class="text-info" href="{{ route('agreements.addendum.download', $addendum) }}" target="_blank">
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
                        <label for="number" class="col-form-label">Fecha Resolución Exenta del Addendum</label>
                        <input type="date" class="form-control" name="res_date" value="{{ $addendum->res_date ? $addendum->res_date->format('Y-m-d') : '' }}">
                    </div>

                    <div class="form-group">
                        <label for="number" class="col-form-label">Número Resolución Exenta del Addendum</label>
                        <input type="number" class="form-control" name="res_number" value="{{ $addendum->res_number }}">
                    </div>

                    <div class="form-group">
                        <label for="for">Archivo Resolución Final PDF SSI
                            @if($addendum->res_file)
                             <a class="text-info" href="{{ route('agreements.addendum.downloadRes', $addendum) }}" target="_blank">
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
