<div>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_origin">Destinatario</label>
            <div class="input-group">
                <select class="form-control" name="to_user_id" id="user" required="" wire:model.defer="to_user_id" >
                    @if($users)
                        @foreach($users as $user)
                            <option value="{{$user->id}}">@if($to_user_id == $user->id)👑@endif {{ $user->shortName }}</option>
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

    @if(count($user_array)>0)
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
            @foreach($user_array as $user)
                <tr><input type='hidden' name='users[]' id="users" value="{{$user->id}}">
                    <input type='hidden' name='enCopia[]' value='0'>
                    <td>{{ $user->organizationalUnit->name }}</td>
                    <td>{{ $user->tinnyName }}</td>
                    <!-- <td><input class="form-check-input" type="checkbox" value=""></td> -->
                    <td>No</td>
                    <!-- <td>
                        <select name="categories[]" id="" class="form-control">
                            <option value=""></option>
                            @foreach($user->organizationalUnit->categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </td> -->
                </tr>
            @endforeach
            @foreach($user_cc_array as $user)
                <tr><input type='hidden' name='users[]' value="{{$user->id}}">
                    <input type='hidden' name='enCopia[]' value='1'>
                    <td>{{ $user->organizationalUnit->name}}</td>
                    <td>{{ $user->tinnyName }}</td>
                    <!-- <td><input class="form-check-input" type="checkbox" value="" checked></td> -->
                    <td>Sí</td>
                    <!-- <td></td> -->
                </tr>
            @endforeach
        </tbody>
    </table>

    @endif
</div>
