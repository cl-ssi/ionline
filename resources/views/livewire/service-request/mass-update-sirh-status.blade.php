<div>
    <h4>Actualizar masivamente estado de carga en Sir. H</h4>
    <textarea wire:model.live="ids" class="form-control mb-3" cols="30" rows="10">
    </textarea>

    <button class="btn btn-primary" wire:click="massUpdate()">Presionar con miedo</button>

    <br>
    {{ $mensaje }}
</div>