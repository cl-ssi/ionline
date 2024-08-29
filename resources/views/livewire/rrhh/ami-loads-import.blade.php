<div>
    <h3 class="mb-3">Importar Cargas Amipass</h3>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label>Archivo (xls) - Máximo archivos con 2.000 filas.</label>
            <input type="file" class="form-control" wire:model.live="file">
        </fieldset>
    </div>

    @error('file') <span class="error">{{ $message }}</span> @enderror
    <div wire:loading wire:target="file"><strong>Cargando</strong></div>

    <div wire:loading.remove>
        <button type="button" class="btn btn-primary mt-1 mb-4" wire:click="save()">Guardar</button>
    </div>

    <div wire:loading.delay class="z-50 static flex fixed left-0 top-0 bottom-0 w-full bg-gray-400 bg-opacity-50">
        <img src="https://paladins-draft.com/img/circle_loading.gif" width="64" height="64" class="m-auto mt-1/4">
    </div>

    <br>
    @if($message2 != "")
        <div class="alert alert-success" role="alert">
            {{ $message2 }}

            <!-- <br>
            <p>A continuación, listado de usuarios de los que no se pudo importar información (No se encuentran registrados en Ionline). Favor regularizar.</p>
            <ol>
                @if($non_existent_users)
                    @foreach($non_existent_users as $user)
                        <li>{{$user}}</li>
                    @endforeach
                @endif
            </ol> -->
        </div>
    @endif

</div>