<div class="row">
    <div class="col">

        <fieldset class="form-group col">
            <label for="for_type">Tipo</label>
            <div id="for-picker-t">
                <select class="form-control" wire:model.live="type" required>
                    <option value=""></option>
                    <option value="Responsable">Responsable</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Todas">Responsable/Supervisor</option>
                </select>
            </div>
        </fieldset>
    
        <fieldset class="form-group col">
            <label for="for_type">Usuario origen</label>
            <div id="for-picker-t">
                @livewire('search-select-user', [
                    'selected_id' => $user_from_id,
                    'emit_name' => 'userFromSelected'
                    ])
            </div>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_type">Usuario destino</label>
            <div id="for-picker">
                @livewire('search-select-user', [
                    'selected_id' => $user_to_id,
                    'emit_name' => 'userToSelected'
                    ])
            </div>
        </fieldset>

        

        <fieldset class="form-group col">
            <button
                onclick="confirm('Esta acción no se puede deshacer, ¿desea continuar?') || event.stopImmediatePropagation()"
                wire:click="derivar" class="btn btn-primary form-control"
                >Derivar</button>
        </fieldset>
    </div>

    <div class="col">
        <h3>Resumen</h3>
        <table class="table table-sm table-bordered">
            <tr>
                <th>Usuario origen:</th>
                <td>{{ $user_from_id }}</td>
            </tr>
            <tr>
                <th>Usuario destino:</th>
                <td>{{ $user_to_id }}</td>
            </tr>
            <tr>
                <th>Disponibles para visar:</th>
                <td>{{ $serviceRequestsMyPendingsCount }}</td>
            </tr>
            <tr>
                <th>No disponibles para visar:</th>
                <td>{{ $serviceRequestsOthersPendingsCount }}</td>
            </tr>
            <tr>
                <th>Derivación:</th>
                <td>{{ $mensaje }}</td>
            </tr>
        </table>
    </div>
</div>
