<div>

    @if($hasFile && $remFiles->first()->filename)
    {{-- Muestra el botón de descarga --}}
    
    <button type="button" style="width: 200px; height: 50px" wire:click="download" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-fw fa-file-excel text-success"></i> Descargar Archivo
    </button>
    <br>
    @if(!$remFiles->first()->locked && $remFiles->first()->filename)    
    <button type="button" style="width: 200px; height: 50px" wire:click="deleteFile" class="btn btn-sm btn-danger" onclick="return confirm('¿está seguro que desea eliminar este Archivo?');">
        <i class="fas fa-fw fa-trash-alt"></i> Borrar Archivo
    </button>
    @endif
    <br>


    @if(auth()->user()->can('Rem: admin'))
    <button type="button" style="width: 200px; height: 50px" wire:click="lock_unlock" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-fw {{ optional($remFiles)->first()->locked ? 'fa-lock' : 'fa-lock-open text-success' }}"></i>Bloquear Archivo
    </button>
    @endif

    @else
    {{-- Muestra el campo de carga de archivo --}}
    @if (request()->is('*/rem_correccion'))
    <div class="input-group">
        <div class="custom-file">
            <input type="file" wire:model.live="file" id="for-file" class="custom-file-input" required>
            <label class="custom-file-label form-control-sm" for="for-file" data-browse="Examinar" style="white-space: nowrap;">
                <div wire:loading wire:target="file"><strong>Cargando</strong></div>
            </label>
            <div class="input-group-append">
                <button type="button" wire:click="save" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>
    </div>
    @endif
    @endif

</div>
