<div class="row">
    <div class="col">
        <fieldset class="form-group col">
            <label for="for_type">Usuario origen</label>
            <select wire:model.lazy="user_from_id" class="form-control" required>
                <option value=""></option>
                @foreach($users as $key => $user)
                <option value="{{ $user->id }}">{{ $user->getFullNameAttribute() }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_type">Usuario destino</label>
            <select wire:model.lazy="user_to_id" class="form-control" required>
                <option value=""></option>
                @foreach($users as $key => $user)
                <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <button wire:click="derivar()" class="btn btn-primary form-control"
            {{ (!$user_from_id OR !$user_to_id)? 'disabled':'' }} >Derivar</button>
        </fieldset>
    </div>

    <div class="col">
        <h3>Resumen</h3>
        <table class="table table-sm table-bordered">
            <tr>
                <th>Usuario origen:</th><td>{{ $user_from_id }}</td>
            </tr>
            <tr>
                <th>Usuario destino:</th><td>{{ $user_to_id }}</td>
            </tr>
            <tr>
                <th>Disponibles para visar:</th><td></td>
            </tr>
            <tr>
                <th>No disponibles para visar:</th><td></td>
            </tr>
            <tr>
                <th>Derivación:</th><td>{{ $mensaje }}</td>
            </tr>
        </table>
    </div>
</div>