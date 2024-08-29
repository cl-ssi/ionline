<div>
    @include('rem.nav')

    <h3 class="mb-3">Import Archivos MDB de REMs</h3>

    <div class="alert alert-primary" role="alert">
        <strong>Importante:</strong> <br>
        <ul>
            <li>Seleccione el archivo desde su computador, 
                espere a que termine de cargar y luego presione el botón azúl para procesar.</li>
            <li>Un solo archivo por cada mdb.</li>
            <li>El archivo debe estar comprimido en zip, 
                ej: archivo 02A21022024.mdb > comprimir en 02A21022024.zip</li>
            <li>El archivo debe pertenecer al año actual o al anterior</li>
        </ul>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-{{ session()->get('status') }} alert-dismissible fade show" role="alert">
            <ol>
                @foreach(session()->get('message') as $key => $message)
                <li>{!! $message !!}</li>
                @endforeach
            </ol>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit="save">
        <div class="row">
            <div class="col-md-8">
                <div class="input-group mb-3 @error('file') is-invalid @enderror">
                    <input class="form-control" type="file" id="formFile" wire:model.live="file">
                    <button wire:click="save" class="btn btn-primary" wire:loading.attr="disabled" @disabled(!$file)>
                        <i class="bi bi-upload" wire:loading.remove></i>
                        <div wire:loading class="spinner-border spinner-border-sm "></div>
                    </button>
                </div>
                @error('file')<span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
   </form>

    @if ($info)
        <pre>
            {{ print_r($info) }}
        </pre>
    @endif
</div>
