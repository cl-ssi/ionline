<div>
    @section('title', 'Constancias de no registro de asistencia')

    @if ($form)
        <h3 class="mb-3">Ingresar constancia de no registro de asistencia</h3>
        <h4>La autoridad que tiene usted asignada es: <strong>{{ $authority->shortName }}</strong></h4>
        <small class="mb-3">(*Si no corresponde, por favor solicitar la corrección de la autoridad con su secretaria antes de hacer el registro)</small>


        <form class="form-row mt-3">
            <div class="form-group col-md-3">
                <label for="date">Fecha y hora</label>
                <input type="datetime-local" class="form-control" wire:model="noAttendanceRecord.date">
                @error('noAttendanceRecord.date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-9">
                <label for="formGroupExampleInput2">Fundamento del no registro</label>
                <input type="text" class="form-control" wire:model="noAttendanceRecord.observation">
                @error('noAttendanceRecord.observation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </form>
        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>
        <br>


    @else
        <div class="form-row">
                <div class="col">
                    <h3 class="mb-3">Listado de constancias de no registro de asistencia</h3>
                </div>
                <div class="col-3 text-end">
                    @if($checkAuthority)
                    <button class="btn btn-success float-right" wire:click="form()">
                        <i class="fas fa-plus"></i> Nueva constancia
                    </button>
                    @else
                    <h5 class="text-danger">No tiene jefatura asociada</h5>
                    @endif
                </div>

            </div>

            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Fecha registro</th>
                        <th>Fundamento</th>
                        <th>Autoridad</th>
                        <th>Estado</th>
                        <th>Observación</th>
                        <th>Fecha revisión</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>
                            @if(is_null($record->status))
                            <button type="button" class="btn btn-sm btn-danger" 
                                onclick="confirm('¿Está seguro que desea borrar el feriado {{ $record->date }}?') || event.stopImmediatePropagation()" 
                                wire:click="delete({{$record}})"><i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </td>
                        <td>{{ $record->date }}</td>
                        <td>{{ $record->observation }}</td>
                        <td>{{ $record->authority->shortName }}</td>
                            <td>
                                @if(is_null($record->status))
                                <i class="fas fa-clock"></i>
                                @elseif($record->status === 1)
                                <i class="fas fa-thumbs-up text-success"></i>
                                @else
                                <i class="fas fa-thumbs-down text-danger"></i>
                                @endif
                            </td>
                            <td>{{ $record->authority_observation }}</td>
                            <td>{{ $record->authority_at }}</td>
                            <td>
                                @if(is_null($record->status))
                                <button type="button" class="btn btn-sm btn-primary" 
                                    wire:click="form({{$record}})"><i class="fas fa-edit"></i></button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        {{ $records->links() }}
    @endif
</div>
