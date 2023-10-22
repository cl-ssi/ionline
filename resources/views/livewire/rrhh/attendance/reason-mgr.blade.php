<div>

    @section('title', 'Lista de motivos de no registro de marca')

    @if ($form)
        <h3>{{ $reason->id ? 'Editar' : 'Crear' }} Feriado</h3>
        
        <div class="row mb-3 gx-2">
            <fieldset class="col-12 col-md-3">
                <label for="for-name">Nombre*</label>
                <input type="text" wire:model.defer="reason.name" class="form-control mt-2">
                @error('reason.name') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>

            <fieldset class="col-12 col-md-5">
                <label for="for-description">Descripción (opcional)</label>
                <input type="text" wire:model.defer="reason.description" class="form-control mt-2">
                @error('reason.description') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>
        </div>
        
        <div class="row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-8">
                <h3 class="mb-3">Listado de Motivos de no registro de marca</h3>
            </div>
            <div class="col-4 text-end">
                <button class="btn btn-success float-right" wire:click="form()">
                    <i class="fas fa-plus"></i> Nuevo Motivo
                </button>
            </div>
        </div>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th width="45px"></th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th width="60px">Editar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reasons as $reason)
                    <tr>
                        <td>
                            @if(is_null($reason->noAttendanceRecords))
                            <button type="button" class="btn btn-sm btn-danger" 
                                onclick="confirm('¿Está seguro que desea borrar el motivo {{ $reason->name }}?') || event.stopImmediatePropagation()" 
                                wire:click="delete({{$reason}})"><i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </td>
                        <td>{{ $reason->name }}</td>
                        <td>{{ $reason->description }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" 
                                wire:click="form({{$reason}})"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
</div>
