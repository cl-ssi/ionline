<div>

    @if(auth()->user()->can('Rem: user') and $rem_file)
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('rem.files.download', $rem_file) }}" target="_blank"><i class="fas fa-download"></i>
        Descargar</a>

        @if($rem_file and $rem_file->filename and $rem_file->is_locked ==0)
        <form method="POST" class="form-horizontal" action="{{ route('rem.files.destroy', $rem_file) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea eliminar el archivo para el mes y año : {{ $rem_file->month }}- {{ $rem_file->year }} ? ' )"><i class="fas fa-trash-alt"></i></button>
        </form>
        @endif
    @endif




    @if(auth()->user()->can('Rem: admin') and $rem_file )
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('rem.files.download', $rem_file) }}" target="_blank"><i class="fas fa-download"></i>
        Descargar</a>
    <button type="button" wire:click="lock_unlock" class="btn btn-sm btn-outline-primary">
        <i class="fas {{$rem_file->is_locked ? 'fa-lock' : 'fa-lock-open' }}"></i>
    </button><br>

    <form method="POST" class="form-horizontal" action="{{ route('rem.files.destroy', $rem_file) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea eliminar el archivo para el mes y año : {{ $rem_file->month }}- {{ $rem_file->year }} ? ' )"><i class="fas fa-trash-alt"></i></button>
    </form>

    @endif

    @if(!$rem_file or $rem_file->locked === 0)
    <form wire:submit.prevent="save">
        <div class="custom-file">
            <input type="file" wire:model="file" class="custom-file-input" id="forfile" required>
            <label class="custom-file-label" for="forfile">Seleccionar Archivo</label>
        </div>

        <div wire:loading wire:target="file"><strong>Cargando</strong></div>


        <button type="submit" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-save"></i>
        </button><br>
    </form>
    @endif



</div>