<div class="row mt-4">
    <div class="col">
            <div class="row g-3">
                <fieldset class="form-group col-md-6 col-12">
                    <label for="for_type">Tipo Noticia</label>
                    <select class="form-select" wire:model="type">
                        <option value="">Seleccione</option>
                        <option value="news">Noticia</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-md-6 col-12">
                    <label for="for_until_date">Publicar hasta</label>
                    <input type="date" class="form-control" id="for_until_date" wire:model="untilAt">
                </fieldset>
            </div>

            <div class="row g-3 mt-1">    
                <fieldset class="form-group col-md-12 col-12">
                    <label for="for_title">Titulo</label>
                    <input class="form-control" type="text" autocomplete="off" wire:model="title">
                </fieldset>

                <fieldset class="form-group col-md-12 col-12">
                    <label for="for_subtitle">Subtítulo</label>
                    <input class="form-control" type="text" autocomplete="off" wire:model="subtitle">
                </fieldset>

                <fieldset class="form-group col-md-12 col-12">
                    <label for="for_image" class="form-label">Imagen</label>
                    <input class="form-control" type="file" id="for_image" wire:model="image">
                </fieldset>

                <fieldset class="form-group">
                    <label for="for_body" class="form-label">Lead</label>
                    <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="lead">{{ $lead }}</textarea>
                </fieldset>

                <fieldset class="form-group">
                    <label for="for_body" class="form-label">Cuerpo de noticia</label>
                    <textarea class="form-control" id="for_body" rows="10" wire:model.debounce.700ms="body">{{ $body }}</textarea>
                </fieldset>
            </div>

            @if(count($errors))
                <div class="alert alert-danger mt-3">
                    <p>Corrige los siguientes errores:</p>
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-3 mt-1">
                <div class="col-12">
                    <button wire:click="saveNews()" 
                        class="btn btn-primary float-end" 
                        type="button">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
    </div>
</div>