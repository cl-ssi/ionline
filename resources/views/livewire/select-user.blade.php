<div>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_origin">Destinatario</label>
            <div class="input-group">
                <select class="form-control" name="to_user_id" id="user" required="" wire:model="to_user_id" >
                    @if($users)
                        @foreach($users as $user)
                            <option value="{{$user->id}}">@if($this->authority != null && $this->authority->user_id == $user->id)👑@endif {{ $user->shortName }}</option>
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
                <!-- <th>Categoría</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($users_array as $key => $user)
                <tr><input style="display:none" name='users[]' class="users" value="{{$user->id}}">
                    <input style="display:none" name='enCopia[]' value='{{$enCopia[$key]}}'>
                    <td>{{ $user->organizationalUnit->name }}</td>
                    <td>{{ $user->tinyName }}</td>
                    <td>
                        @if($enCopia[$key]==1)Sí
                        @else No @endif
                    </td>
                    <!-- <td>
                        @if($enCopia[$key]==0)
                            <select name="categories[]" id="" class="form-control">
                                <option value=""></option>
                                @foreach($user->organizationalUnit->categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>

    @endif
</div>
