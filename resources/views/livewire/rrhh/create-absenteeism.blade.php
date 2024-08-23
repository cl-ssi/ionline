<div>
    <div class="row mb-3">
        <div class="col">
            <h3 class="">Crear Ausentismo</h1>
        </div>
        <div class="col text-end">
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="row g-2 mb-3">
            <div class="col">
                <label for="absenteeism_type_id" class="form-label">Tipo de Ausentismo*</label>
                <select class="form-select" id="absenteeism_type_id" wire:model.defer="absenteeism_type_id" required>
                    <option value="">Seleccione un tipo</option>
                    @foreach($absenteeismTypes as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('absenteeism_type_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-2">
                <label for="finicio" class="form-label">Fecha de Inicio*</label>
                <input type="date" class="form-control" id="finicio" wire:model.defer="finicio" required>
                @error('finicio') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="col-2">
                <label for="ftermino" class="form-label">Fecha de Término*</label>
                <input type="date" class="form-control" id="ftermino" wire:model.defer="ftermino" required>
                @error('ftermino') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-3">
                <label for="jornada" class="form-label">Jornada</label>
                <select class="form-select" id="jornada" wire:model.defer="jornada">
                    <option value="">Seleccione una jornada</option>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                    <option value="TO">TO</option>
                </select>
                <div id="jornada_help" class="form-text">Sólo para permisos administrativos.</div>
                @error('jornada') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <label for="observacion" class="form-label">Fundamento</label>
                <textarea class="form-control" id="observacion" wire:model.defer="observacion" rows="1"></textarea>
                @error('observacion') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('rrhh.absenteeisms.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
