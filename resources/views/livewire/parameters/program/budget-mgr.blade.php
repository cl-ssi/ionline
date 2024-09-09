<div>
    @section('title', 'Lista de Presupuestos')

    @if ($formActive)
        <h3>{{ $budget->id ? 'Editar' : 'Crear' }} Presupuesto</h3>

        <div class="form-row mb-3">
            <fieldset class="col-12 col-md-2">
                <label for="for-year">Año</label>
                <select class="form-control" wire:model.live="year" wire:change="updatePrograms">
                    <option value="">Seleccionar Año</option>
                    <option value="{{ now()->year }}">{{ now()->year }}</option>
                    <option value="{{ now()->year - 1 }}">{{ now()->year - 1 }}</option>
                </select>
            </fieldset>

            <fieldset class="col-12 col-md-2">
                <label for="for-subtitle">Subtítulo</label>
                <select class="form-control" wire:model.live="selectedSubtitle" wire:change="updatePrograms">
                    <option value="">Seleccionar Subt</option>
                    @foreach ($subtitles as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="col-12 col-md-4">
                <label for="for-program">Programa*</label>
                <select class="form-control" wire:model.live="program">
                    <option value="">Seleccionar Programa</option>
                    @foreach ($programs as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="col-12 col-md-3">
                <label for="for-ammount">Monto*</label> <small class="text-muted">Valor aumentar/disminuir (negativo)</small>
                <input type="number" wire:model="ammount" class="form-control">
                @error('ammount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </fieldset>
        </div>

        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>
    @else
        <div class="form-row">
            <div class="col">
                <h3 class="mb-3">Listado de Presupuestos</h3>
            </div>
            <div class="col text-end">
                <button class="btn btn-success float-right" wire:click="showForm()">
                    <i class="fas fa-plus"></i> Nuevo presupuesto
                </button>
            </div>
        </div>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Editar</th>
                    <th>Programa</th>
                    <th>Monto</th>
                    <th>Periodo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $budget)
                    <tr>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                wire:click="showForm({{ $budget }})"><i class="fas fa-edit"></i></button>
                        </td>
                        <td>{{ $budget->program->name }}</td>
                        <td>{{ $budget->ammount }}</td>
                        <td>{{ $budget->program->period }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="confirm('¿Está seguro que desea borrar el feriado {{ $budget->ammount }}?') || event.stopImmediatePropagation()"
                                wire:click="delete({{ $budget }})"><i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $budgets->links() }}
    @endif
</div>
