<div>
    <div class="form-row">
        <!-- Tipo de visación -->
        <fieldset class="form-group col-3 col-md-3">
            <label for="for_endorse_type">Tipo de visación</label>
            <select class="form-control" name="endorse_type" wire:model.change="endorse_type" required>
                <!-- <option value="">Seleccione tipo de visación</option> -->
                @php($endorseTypes = array('No requiere visación', 'Visación opcional', 'Visación en cadena de responsabilidad'))
                @foreach($endorseTypes as $endorseType)
                    <option value="{{ $endorseType }}" 
                        @if(isset($signature) && $signature->endorse_type == $endorseType) 
                            selected 
                        @endif
                    >
                        {{ $endorseType }}
                    </option>
                @endforeach
            </select>
        </fieldset>


        <!-- Checkbox para visadores como firmantes -->
        <fieldset class="form-group col-3 col-md-3 d-flex align-items-center justify-content-center">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="visatorAsSignature" id="for_visatorAsSignature" value="1"
                    {{ $selectedDocumentType == 9 ? 'checked' : '' }} {{$endorse_type_enabled}}>
                <label class="form-check-label" for="for_visatorAsSignature">Visadores como firmantes</label>
            </div>
        </fieldset>


        <!-- Mensaje adicional -->
        <fieldset class="form-group col-12 col-md-6">
            <label for=""></label>
            <div class="form-check">
                <small id="presumend_help" class="form-text text-muted">
                    Si se selecciona, los usuarios visadores pasarán a ser firmantes. Igualmente se debe seleccionar un usuario en firmante.
                </small>
            </div>
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col-3 col-md-4">
            <label for="ou">Unidad Organizacional</label>
            <div wire:ignore id="for-bootstrap-select">
                <select class="form-control selectpicker" data-live-search="true" id="ou" name="to_ou_id" 
                        data-size="5" wire:model.live="to_ou_id" data-container="#for-bootstrap-select">
                        <option value=""></option>
                        @if($ouRoots)
                            @foreach($ouRoots as $ou)
                                <option value="{{ $ou['id'] }}">{{ $ou['name'] }}</option>
                            @endforeach
                        @endif

                </select>
            </div>
        </fieldset>

        <fieldset class="form-group col-3 col-md-4">
            <label for="for_origin">Funcionarios</label>
            <div class="input-group">
                <select class="form-control" name="to_user_id" id="user" wire:model="to_user_id" wire:key="{{ $to_ou_id }}" {{$endorse_type_enabled}}>
                    @if($users)
                        @foreach($users as $user)
                            <option value="{{$user->id}}">@if($this->authority != null && $this->authority->user_id == $user->id)👑@endif {{ $user->tinyName }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </fieldset>

        @if($selectedDocumentType == 9)
            <fieldset class="form-group col-3 col-md-2">
                <label for="">&nbsp;</label>
                <button class="btn text-white btn-info btn-block" wire:click.prevent="add({{$i}}, 'elaborador')" {{$endorse_type_enabled}}>
                    <i class="fa fa-user-plus"></i> Agregar Elaborador
                </button>
            </fieldset>

            <fieldset class="form-group col-3 col-md-2">
                <label for="">&nbsp;</label>
                <button class="btn text-white btn-success btn-block" wire:click.prevent="add({{$i}}, 'revisador')" {{$endorse_type_enabled}}>
                    <i class="fa fa-user-plus"></i> Agregar Revisador
                </button>
            </fieldset>

            <input type="hidden" name="visator_types" id="for_visator_types" value="{{serialize($visatorType)}}">
        @else
            <fieldset class="form-group col-3 col-md-4">
                <label for="">&nbsp;</label>
                <button class="btn text-white btn-info btn-block" wire:click.prevent="add({{$i}})" {{$endorse_type_enabled}}>
                    <i class="fa fa-user-plus"></i> Agregar Visador
                </button>
            </fieldset>
        @endif

    </div>

    @if($message)
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @endif

    @if(count($users_array)>0)
        <table id="tabla_funcionarios" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Unidad Organizacional</th>
                    <th>Funcionario</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users_array as $key => $user_key)
                    <tr>
                        <input style="display:none" name="ou_id_visator[]" value='{{$user_key->organizationalUnit->id}}'>
                        <input style="display:none" name='user_visator[]' class='users' value='{{$user_key->id}}'>
                        <td>{{ $user_key->organizationalUnit->name }}</td>
                        <td>{{ $user_key->tinyName }}</td>
                        <td>
                            @if(isset($visatorType[$key]))
                                <label 
                                    @if($visatorType[$key] == 'elaborador')
                                        class="text-info"
                                    @elseif($visatorType[$key] == 'revisador')
                                        class="text-success" 
                                    @endif    
                                    for="">{{$visatorType[$key]}}
                                </label>
                            @endif
                        </td>
                        <td>
                        <button type="button" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" wire:click="remove({{ $key }})">
                            <i class="fas fa-trash"></i>
                        </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
