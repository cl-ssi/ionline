<div class="g-3">
    <div class="row g-3 mb-3">
        <fieldset class="form-group">
            <label for="for_title">Título</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="title">
        </fieldset>

        <fieldset class="form-group">
            <label for="for_template" class="form-label">Plantilla</label>
            <textarea class="form-control" 
                id="for_template" 
                rows="3" 
                placeholder="Copia aquí tu plantilla"
                wire:model="template"></textarea>
        </fieldset>    
    </div>

    <div class="col-md-12 col-12">
        <a type="button" class="btn btn-primary float-end" wire:click="save()">
            <i class="fas fa-save"></i> Guardar
        </a>
    </div>
</div>
