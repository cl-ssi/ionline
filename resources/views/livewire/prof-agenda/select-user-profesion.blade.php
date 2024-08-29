<div class="row">
    <fieldset class="form-group col col-md-5">
        <label for="for_type">Profesión</label>
        <select class="form-control" name="profession_id" wire:model.live="profession_id" wire:change="change">
            <option value=""></option>
            @foreach($professions as $profession)
                <option value="{{$profession->id}}" @selected($profession_id == $profession->id)>{{$profession->name}}</option>
            @endforeach
        </select>
    </fieldset>

    <fieldset class="form-group col col-md-5">
        <label for="for_type">Funcionario</label>
        <select class="form-control" name="user_id">
            <option value=""></option>
            @if($users)
                @foreach($users as $user)
                    <option value="{{$user->id}}" @selected($user_id == $user->id)>{{$user->shortName}}</option>
                @endforeach
            @endif
        </select>
    </fieldset>
    
    <fieldset class="form-group col col-md-2">
        <label for="for_end_date"><br></label>
        <button type="submit" class="btn btn-success form-control">
            <i class="fa fa-folder-open"></i> Buscar
        </button>
    </fieldset>
</div>
