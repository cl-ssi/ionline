<div class="text-center">
    <div class="form-control" style="height: auto; background-color: #f0f0f0; color: #333;">
        {{ $dte->observation }} 
    </div>
    <textarea
        wire:model="observation" 
        class="form-control"
        rows="{{ isset($rows) ? $rows : 12 }}" 
        cols="{{ isset($cols) ? $cols : 50 }}"
        placeholder="Agregar observación en caso de ser necesario"
    ></textarea>
    <button wire:click="saveObservation" class="btn btn-primary">Guardar</button>
    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>
