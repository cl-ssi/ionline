<div>
    {{-- Care about people's approval and you will be their prisoner. --}}    
    <div class="input-group">
        <div class="custom-file">
            <input type="file" wire:model="file" id="for-file" class="custom-file-input" required>
            <label class="custom-file-label" for="for-file" data-browse="Examinar">
                <div wire:loading wire:target="file"><strong>Cargando</strong></div>
                {{ optional($file)->getClientOriginalName() ?? 'Archivo' }}
            </label>
            <div class="input-group-append">
                <button type="button" wire:click="save" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-save"></i>
                </button>
            </div>
            
        </div>
    </div>

</div>