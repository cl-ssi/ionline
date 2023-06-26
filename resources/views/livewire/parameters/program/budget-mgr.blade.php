<div>

    @section('title', 'Lista de Presupuestos')

    @if($form)
        <h3>{{ $budget->id ? 'Editar' : 'Crear' }} Presupuesto</h3>
        
        <div class="form-row mb-3">

            <fieldset class="col-12 col-md-5">
                <label for="for-date">Programa*</label>
                <select class="form-control" wire:model.defer="budget.program_id">
                    <option value="">Todas</option>
                    @foreach($programs->sort() as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('budget.program_id') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>
            
            <fieldset class="col-12 col-md-3">
                <label for="for-ammount">Monto*</label>
                <input type="text" wire:model.defer="budget.ammount" class="form-control">
                @error('budget.ammount') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>
            
            <fieldset class="col-12 col-md-3">
                <label for="for-period">Periodo*</label>
                <input type="month" wire:model.defer="budget.period" class="form-control">
                @error('budget.period') <span class="text-danger">{{ $message }}</span> @enderror
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
                <button class="btn btn-success float-right" wire:click="form()">
                    <i class="fas fa-plus"></i> Nuevo presupuesto
                </button>
            </div>
        </div>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Editar</th>
                    <th>Programa</th>
                    <th>Periodo</th>
                    <th>Monto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($budgets as $budget)
                    <tr>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" 
                                wire:click="form({{$budget}})"><i class="fas fa-edit"></i></button>
                        </td>
                        <td>{{ $budget->program->name }}</td>
                        <td>{{ $budget->period->format('Y-m') }}</td>
                        <td>{{ $budget->ammount }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" 
                                onclick="confirm('¿Está seguro que desea borrar el feriado {{ $budget->ammount }}?') || event.stopImmediatePropagation()" 
                                wire:click="delete({{$budget}})"><i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $budgets->links() }}
    @endif
    
</div>
