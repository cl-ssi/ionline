<div class="modal fade" id="addModalAddendum" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Nuevo Addendum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-add" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ csrf_field() }}

                    <input type="hidden" name="agreement_id" value="{{$agreement->id}}">
                    
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="forreferente">Referente</label>
                        <!-- <input type="text" name="referente" class="form-control" id="forreferente" value="{{ $agreement->referente }}" > -->
                        <select name="referrer_id" class="form-control selectpicker" data-live-search="true" title="Seleccione referente" required>
                            @foreach($referrers as $referrer)
                            <option value="{{$referrer->id}}" @if(isset($agreement->referrer->id) && $referrer->id == $agreement->referrer->id) selected @endif>{{$referrer->fullName}}</option>
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

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
