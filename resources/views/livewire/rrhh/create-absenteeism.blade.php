<div>
    <div class="row mb-3">
        <div class="col">
            <h3 class="">Crear Ausentismo</h1>
        </div>
        <div class="col text-end">
            
        </div>
    </div>

    <form wire:submit="save">
        <div class="row g-2 mb-3">
            <div class="col">
                <label for="absenteeism_type_id" class="form-label">Tipo de Ausentismo*</label>
                <select class="form-select" id="absenteeism_type_id" wire:model="absenteeism_type_id" required>
                    <option value="">Seleccione un tipo</option>
                    @foreach($absenteeismTypes as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('absenteeism_type_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-2">
                <label for="finicio" class="form-label">Fecha de Inicio*</label>
                <input type="date" class="form-control" id="finicio" wire:model="finicio" required>
                @error('finicio') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="col-2">
                <label for="ftermino" class="form-label">Fecha de Término*</label>
                <input type="date" class="form-control" id="ftermino" wire:model="ftermino" required>
                @error('ftermino') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-3">
                <label for="jornada" class="form-label">Jornada</label>
                <select class="form-select" id="jornada" wire:model="jornada">
                    <option value="">Seleccione una jornada</option>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                    <option value="TO">TODO EL DÍA</option>
                </select>
                <div id="jornada_help" class="form-text">Sólo para permisos administrativos.</div>
                @error('jornada') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <label for="observacion" class="form-label">Fundamento</label>
                <textarea class="form-control" id="observacion" wire:model="observacion" rows="1"></textarea>
                @error('observacion') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

        </div>

        <p> La solicitud será enviada para su aprobación a: <strong>{{ auth()->user()->boss->shortName }}</strong><br> 
            <strong>Importante: </strong>
                Si no corresponde a su jefatura, primero solicite la corrección con la secretaria de su departamento 
                antes de crear el permiso.
            </p>

        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('rrhh.absenteeisms.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
