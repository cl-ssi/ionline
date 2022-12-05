<div>
    <div class="form-row">
        <fieldset class="form-group col-8 col-md-4">
            <label for="for_endorse_type">Tipo de visación</label>
                <select class="form-control" name="endorse_type" required>
                <option value="">Seleccione tipo de visación</option>
                @php($endorseTypes = array('No requiere visación','Visación opcional','Visación en cadena de responsabilidad'))
                @foreach($endorseTypes as $endorseType)
                <option value="{{$endorseType}}" @if(isset($signature) && $signature->endorse_type == $endorseType) selected @endif>{{$endorseType}}</option>
                @endforeach
            </select>
        </fieldset>



        @if($selectedDocumentType === 'Protocolo')
            <fieldset class="form-group col-12 col-md-2">
                <label for="">&nbsp;</label>
                <button class="btn text-white btn-info btn-block" wire:click.prevent="add({{$i}}, 'elaborador')">
                    <i class="fa fa-user-plus"></i> Agregar Elaborador
                </button>
            </fieldset>

            <fieldset class="form-group col-12 col-md-2">
                <label for="">&nbsp;</label>
                <button class="btn text-white btn-success btn-block" wire:click.prevent="add({{$i}}, 'revisador')">
                    <i class="fa fa-user-plus"></i> Agregar Revisador
                </button>
            </fieldset>

            <input type="hidden" name="visator_types" id="for_visator_types" value="{{serialize($visatorType)}}">
        @else
            <fieldset class="form-group col-4 col-md-2">
                <label for="">&nbsp;</label>
                <button class="btn text-white btn-info btn-block" wire:click.prevent="add({{$i}})">
                    <i class="fa fa-user-plus"></i> Agregar Visador
                </button>
            </fieldset>
        @endif

        <fieldset class="form-group {{$selectedDocumentType === 'Protocolo' ? 'offset-1' : 'offset-3' }} col-12 col-md-3">
            <label for=""></label>
            <div class="form-check">
                <input type="checkbox" class="form-check-input"
                       name="visatorAsSignature" id="for_visatorAsSignature" value="1" {{$selectedDocumentType === 'Protocolo' ? 'checked' : '' }} >
                <label class="form-check-label" for="for_visatorAsSignature">Visadores como firmantes</label>
               <small id="presumend_help" class="form-text text-muted">
                   Si se selecciona, los usuarios visadores pasarán a ser firmantes. Igualmente se debe seleccionar un usuario en firmante. </small>
            </div>
        </fieldset>

    </div>


    @foreach($inputs as $key => $value)
        <div class="form-row">
            <div class="col-5">
                <label 
                    @if($visatorType[$key] === 'elaborador')
                        class="text-info"
                    @elseif($visatorType[$key] === 'revisador')
                        class="text-success" 
                    @endif    
                    for="">{{ucfirst($visatorType[$key])}} - Unidad Organizacional
                </label>
            </div>
            <div class="col-5">
                <label 
                    @if($visatorType[$key] === 'elaborador')
                        class="text-info"
                    @elseif($visatorType[$key] === 'revisador')
                        class="text-success" 
                    @endif    
                    for="">{{ucfirst($visatorType[$key])}} - Usuario
                </label>
            </div>
        </div>
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-5">
               <select name="ou_id_visator[]" wire:model="organizationalUnit.{{ $value }}" class="form-control" {{$requiredVisator}} >
                    <option value=''></option>

                    @foreach($ouRoots as $ouRoot)
                        <option value="{{ $ouRoot->id }}">
                            {{ $ouRoot->name  . ' - ' . $ouRoot->establishment->alias}}
                        </option>
                        @foreach($ouRoot->childs as $child_level_1)
                            <option value="{{ $child_level_1->id }}">
                                &nbsp;&nbsp;&nbsp;
                                {{ $child_level_1->name  . ' - ' . $ouRoot->establishment->alias}}
                            </option>
                            @foreach($child_level_1->childs as $child_level_2)
                                <option value="{{ $child_level_2->id }}">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $child_level_2->name  . ' - ' . $ouRoot->establishment->alias}}
                                </option>
                                @foreach($child_level_2->childs as $child_level_3)
                                    <option value="{{ $child_level_3->id }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $child_level_3->name  . ' - ' . $ouRoot->establishment->alias}}
                                    </option>
                                    @foreach($child_level_3->childs as $child_level_4)
                                        <option value="{{ $child_level_4->id }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ $child_level_4->name  . ' - ' . $ouRoot->establishment->alias}}
                                        </option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach

                </select>
            </fieldset>
            <fieldset class="form-group col-12 col-md-5">
                @if(array_key_exists($value,$users))
                   <select name="user_visator[]" wire:model="user.{{$value}}" class="form-control" {{$requiredVisator}}>
                        <option value=''></option>
                        @foreach($users[$value] as $user)
                            <option value={{ $user->id }}>{{ $user->fullName }}</option>
                        @endforeach
                    </select>
                @endif
            </fieldset>
            <fieldset class="form-group col-12 col-md-2">
                <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})"> <i class="fa fa-user-minus "></i> Remover</button>
            </fieldset>
        </div>
    @endforeach
</div>
