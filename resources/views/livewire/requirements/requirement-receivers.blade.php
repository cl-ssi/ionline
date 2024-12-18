<div>
    <div class="form-row">
        <fieldset class="form-group @if($parte_id <> 0) col-12 @else col-6 @endif">
            <label for="ou">Unidad Organizacional</label>
            <div wire:ignore id="for-bootstrap-select">
                <!-- <select class="form-control" data-container="#for-bootstrap-select"> -->
                <select class="form-control selectpicker" data-live-search="true" id="ou" name="to_ou_id" 
                        required data-size="5" wire:model.live="to_ou_id" data-container="#for-bootstrap-select">
                        <option value=""></option>
                        @if($ouRoots)
                            @foreach($ouRoots as $ou)
                                <option value="{{ $ou['id'] }}">{{ $ou['name'] }}</option>
                            @endforeach
                        @endif

                </select>
            </div>
        </fieldset>

        <fieldset class="form-group @if($parte_id <> 0) col-12 @else col-6 @endif">
            <label for="for_origin">Destinatario</label>
            <div class="input-group">
                <select class="form-control" name="to_user_id" id="user" required="" wire:model="to_user_id" wire:key="{{ $to_ou_id }}">
                    @if($users)
                        @foreach($users as $user)
                            <option value="{{$user->id}}">@if($this->authority != null && $this->authority->user_id == $user->id)👑@endif {{ $user->tinyName }}</option>
                        @endforeach
                    @endif
                </select>
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-primary add-destinatario"
                            data-toggle="tooltip" data-placement="top"
                            title="Utilizar para agregar más de un destinatario" wire:click="add">
                        <i class="fas fa-user-plus"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary add-destinatario-cc"
                            data-toggle="tooltip" data-placement="top"
                            title="Utilizar para agregar en copia al requerimiento" wire:click="add_cc">
                        <i class="far fa-copy"></i>
                    </button>
                </div>
            </div>
        </fieldset>

    </div>

    @if($message)
    <div class="alert alert-danger" role="alert">
        {{ $message }}
    </div>
    @endif

    @if(count($users_array)>0)
        <table id="tabla_funcionarios" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Unidad Organizacional</th>
                    <th>Destinatario</th>
                    <th>En copia</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users_array as $key => $user_key)
                    <tr><input style="display:none" name='users[]' class='users' value='{{$user_key->id}}'>
                        <input style="display:none" name='enCopia[]' value='{{$enCopia[$key]}}'>
                        <td>{{ $user_key->organizationalUnit->name }}</td>
                        <td>{{ $user_key->tinyName }}</td>
                        <td>
                            @if($enCopia[$key]==1)Sí
                            @else No @endif
                        </td>
                        <td>
                            @if($enCopia[$key]==0)
                                <select name="category{{$key}}" id="" class="form-control">
                                    <option value=""></option>
                                    @foreach($user_key->organizationalUnit->categories->sortBy('name') as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select id="" class="form-control" disabled>
                                    <option value=""></option>
                                </select>
                                <input type="hidden" name="category{{$key}}" value="">
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
