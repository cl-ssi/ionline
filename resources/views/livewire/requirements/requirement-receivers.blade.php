<div>
    <div class="form-row">
        <fieldset class="form-group @if($parte_id <> 0) col-12 @else col-6 @endif">
            <label for="ou">Unidad Organizacional</label>
            <div wire:ignore id="for-bootstrap-select">
                <!-- <select class="form-control" data-container="#for-bootstrap-select"> -->
                <select class="form-control selectpicker" data-live-search="true" id="ou" name="to_ou_id" 
                        required data-size="5" wire:model.lazy="to_ou_id" data-container="#for-bootstrap-select">
                        <option value=""></option>
                    @foreach($ouRoots as $ouRoot)
                        @if($ouRoot->name != 'Externos')
                            <option value="{{ $ouRoot->id }}">
                            {{($ouRoot->establishment->alias ?? '')}}-{{ $ouRoot->name }}
                            </option>
                            @foreach($ouRoot->childs as $child_level_1)

                                <option value="{{ $child_level_1->id }}">
                                    &nbsp;&nbsp;&nbsp;
                                    {{($child_level_1->establishment->alias ?? '')}}-{{ $child_level_1->name }}
                                </option>
                                @foreach($child_level_1->childs as $child_level_2)
                                    <option value="{{ $child_level_2->id }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{($child_level_2->establishment->alias ?? '')}}-{{ $child_level_2->name }}
                                    </option>
                                    @foreach($child_level_2->childs as $child_level_3)
                                        <option value="{{ $child_level_3->id }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{($child_level_3->establishment->alias ?? '')}}-{{ $child_level_3->name }}
                                        </option>
                                        @foreach($child_level_3->childs as $child_level_4)
                                            <option value="{{ $child_level_4->id }}">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{($child_level_4->establishment->alias ?? '')}}-{{ $child_level_4->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
        </fieldset>

        <fieldset class="form-group @if($parte_id <> 0) col-12 @else col-6 @endif">
            <label for="for_origin">Destinatario</label>
            <div class="input-group">
                <select class="form-control" name="to_user_id" id="user" required="" wire:model.defer="to_user_id" >
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{ $user->tinnyName }}</option>
                    @endforeach
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
                <th>Categoría</th>
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
                    <td>
                        <select name="categories[]" id="" class="form-control">
                            <option value=""></option>
                            @foreach($user->organizationalUnit->categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
            @foreach($user_cc_array as $user)
                <tr><input type='hidden' name='users[]' value="{{$user->id}}">
                    <input type='hidden' name='enCopia[]' value='1'>
                    <td>{{ $user->organizationalUnit->name}}</td>
                    <td>{{ $user->tinnyName }}</td>
                    <!-- <td><input class="form-check-input" type="checkbox" value="" checked></td> -->
                    <td>Sí</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @endif
</div>
