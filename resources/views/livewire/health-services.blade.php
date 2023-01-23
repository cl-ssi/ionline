<div>

    @section('title', 'Lista de Servicios de Salud')

    @if ($form)
        <h3>{{ $healthService->id ? 'Editar' : 'Crear' }} Servicio de Salud</h3>
        
        <div class="form-row mb-3">
            <fieldset class="col-12 col-md-4">
                <label for="for-name">Nombre*</label>
                <input type="text" wire:model.defer="healthService.name" class="form-control">
                @error('healthService.name') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>

            <fieldset class="col-12 col-md-4">
                <label for="for-date">Región</label>
                <select class="form-control" wire:model.defer="healthService.region_id" required>
                    <option value=""></option>
                    @foreach($regions->sort() as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('healthService.region') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>
        </div>
        
        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
                <button type="button" class="btn btn-sm btn-danger float-right" 
                            onclick="confirm('¿Está seguro que desea borrar el servicio de salud: {{ $healthService->name }}?') || event.stopImmediatePropagation()" 
                            wire:click="delete({{$healthService}})"><i class="fas fa-trash"></i>
                            </button>
            </div>
        </div>
    @else
        <div class="form-row">
            <div class="col">
                <h3 class="mb-3">Listado de Feriados</h3>
            </div>
            <div class="col text-end">
                <button class="btn btn-success float-right" wire:click="form()">
                    <i class="fas fa-plus"></i> Nuevo Feriado
                </button>
            </div>
        </div>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>º</th>
                    <th>Nombre</th>
                    <th>Región</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($healthServices as $index => $healthService)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $healthService->name }}</td>
                        <td>{{ optional($healthService->region)->name ?? 'Todas' }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" 
                                wire:click="form({{$healthService}})"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
</div>
