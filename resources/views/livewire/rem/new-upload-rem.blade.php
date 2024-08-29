@if (request()->is('*/rem_original'))
    <div>
        @if ($hasFile && $remFiles->first()->filename)
            {{-- Muestra el botón de descarga --}}

            <div class="mt-3">
                <button type="button" wire:click="download" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-fw fa-file-excel text-success"></i> Descargar Archivo
                </button>

                @if (!$remFiles->first()->locked && $remFiles->first()->filename)
                    <button type="button" wire:click="deleteFile" class="btn btn-sm btn-danger ml-2" onclick="return confirm('¿Está seguro que desea eliminar este Archivo?');">
                        <i class="fas fa-fw fa-trash-alt"></i> Borrar Archivo
                    </button>
                @endif
            </div>

            <br>


            @if (auth()->user()->can('Rem: admin'))
                <div class="mt-3">
                    <button type="button" wire:click="lock_unlock" class="btn btn-sm {{ optional($remFiles)->first()->locked ? 'btn-outline-danger' : 'btn-outline-primary' }}">
                        <i class="fas fa-fw {{ optional($remFiles)->first()->locked ? 'fa-lock' : 'fa-lock-open text-success' }}"></i>
                        {{ optional($remFiles)->first()->locked ? 'Desbloquear' : 'Bloquear' }} Archivo
                    </button>
                </div>
            @endif

            
        @else
            {{-- Muestra el campo de carga de archivo --}}
            <div class="input-group" style="display: flex; align-items: center;">
                <div class="custom-file" style="margin-right: 10px;">
                    <input type="file" wire:model.live="file" id="for-file" accept=".xlsx,.xls,.xlsm" required>
                    <div wire:loading wire:target="file"><strong>Cargando</strong></div>
                    </label>
                </div>
                <div class="text-center">
                    <button type="button" wire:click="save" class="btn btn-primary btn-circle" >
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>

        @endif

    </div>
@endif

@if (request()->is('*/rem_correccion'))
    <div>
        {{-- Muestra el campo de carga de archivo --}}
        <div class="input-group">
            <div class="custom-file">
                <input type="file" wire:model.live="file" id="for-file" class="custom-file-input" accept=".xlsx,.xls"
                    required>
                <label class="custom-file-label form-control-sm" for="for-file" data-browse="Examinar"
                    style="white-space: nowrap;">
                    <div wire:loading wire:target="file"><strong>Cargando</strong></div>
                </label>
            </div>
            <div class="text-center">
                <button type="button" wire:click="save" class="btn btn-primary btn-circle">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>

        @if ($isCorreccion && $remFiles->first()->filename)
            {{-- Muestra el botón de descarga --}}
            <button type="button" style="width: 200px; height: 50px" wire:click="download"
                class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-fw fa-file-excel text-success"></i> Descargar Archivo
            </button>
            <br>
            @if (!$remFiles->first()->locked && $remFiles->first()->filename && $isCorreccion)
                <button type="button" style="width: 200px; height: 50px" wire:click="deleteFile"
                    class="btn btn-sm btn-danger"
                    onclick="return confirm('¿está seguro que desea eliminar este Archivo?');">
                    <i class="fas fa-fw fa-trash-alt"></i> Borrar Archivo
                </button>
            @endif
            <br>
        @endif
    </div>
@endif
