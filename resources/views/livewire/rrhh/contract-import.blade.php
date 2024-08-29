<div>

    <h3 class="mb-3">Importar contratos SIRH</h3>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label>Archivo (Descargar de sirh en formato txt)</label>
            <input type="file" class="form-control" wire:model.live="file">
        </fieldset>
    </div>
    @error('file') <span class="error">{{ $message }}</span> @enderror
    <div wire:loading wire:target="file"><strong>Cargando</strong></div>

    <div wire:loading.remove>
        <button type="button" class="btn btn-primary mt-1 mb-4" wire:click="save()">Guardar</button>
        <button type="button" class="btn btn-secondary mt-1 mb-4" wire:click="process()">Procesar</button>
    </div>

    <div wire:loading.delay class="z-50 static flex fixed left-0 top-0 bottom-0 w-full bg-gray-400 bg-opacity-50">
        <img src="https://paladins-draft.com/img/circle_loading.gif" width="64" height="64" class="m-auto mt-1/4">
    </div>

    <br>
    @if($message2 != "")
        <div class="alert alert-success" role="alert">
            {{ $message2 }}<br><br>

            @if($non_existent_users>0)<p>Falta crear <b>{{$non_existent_users}}</b> funcionarios en sistema (Presionar botón "Procesar"). </p>@endif
            @if(count($non_existent_ous)>0)<p>Se detectaron <b>{{count($non_existent_ous)}}</b> códigos SIRH inexistentes en sistema, regularizar: </p>@endif
            <ol>
                @if($non_existent_ous)
                    @foreach($non_existent_ous as $key => $ou)
                        <li>{{$ou}}</li>
                    @endforeach
                @endif
            </ol>
            
        </div>
    @endif
    
</div>
