<div class="row">
    <div class="col">
        <fieldset class="form-group col">
            <label for="for_type">Usuario origen</label>
            <div id="for-picker-t" wire:ignore>
              <select wire:model.lazy="user_from_id" class="form-control selectpicker" data-live-search="true" data-size="5" data-container="#for-picker-t">
                  <option value=""></option>
                  @foreach($users as $key => $user)
                  <option value="{{ $user->id }}">{{ $user->getFullNameAttribute() }}</option>
                  @endforeach
              </select>
            </div>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_type">Usuario destino</label>
            <div id="for-picker" wire:ignore>
                <select wire:model.lazy="user_to_id" class="form-control selectpicker" data-live-search="true" data-size="5" required data-container="#for-picker">
                    <option value=""></option>
                    @foreach($users as $key => $user)
                    <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
                    @endforeach
                </select>
            </div>
        </fieldset>

        <fieldset class="form-group col">
            <button onclick="confirm('Esta acción no se puede deshacer, ¿desea continuar?') || event.stopImmediatePropagation()" wire:click="derivar()" class="btn btn-primary form-control"
            {{ (!$user_from_id OR !$user_to_id)? 'disabled':'' }} onclick="" >Derivar</button>
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
                <th>Disponibles para visar:</th><td>{{ $serviceRequestsMyPendingsCount }}</td>
            </tr>
            <tr>
                <th>No disponibles para visar:</th><td>{{ $serviceRequestsOthersPendingsCount }}</td>
            </tr>
            <tr>
                <th>Derivación:</th><td>{{ $mensaje }}</td>
            </tr>
        </table>
    </div>
</div>
