<div>
    <textarea class="form-control" 
        cols="30" 
        rows="4" 
        wire:model="summary.observation">{{ $summary->observation }}</textarea>
    <button 
        type="button" 
        class="btn btn-outline-primary float-right mt-2"
        wire:click="updateObservation">Actualizar</button>
</div>
