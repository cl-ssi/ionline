<div class="input-group">
    <input type="number" class="form-control" name="run" 
        wire:model.debounce.700ms="run"
        placeholder="Run sin digito verificador">
    <div class="input-group-append">
        <span class="input-group-text">{{ $dv }}</span>
        <input type="hidden" name="dv" value="{{ $dv }}">
        <button class="btn btn-outline-secondary" type="submit" 
            id="buscar">Buscar</button>
    </div>
</div>