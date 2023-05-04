<form wire:submit.prevent="upload">

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('finance.dtes.index') }}">Ver dtes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('finance.dtes.upload') }}">Cargar archivo</a>
        </li>
    </ul>

    
    <h3 class="mb-3">Cargar archivo de Acepta con reporte de DTEs</h3>

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>



    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"> <i class="fas fa-fw fa-upload"></i> Cargar Archivo</button>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="dte_file" wire:model="dtes">
            <label class="custom-file-label" for="dte_file" data-browse="Examinar">Archivo xls máximo 20 mb</label>
        </div>
    </div>

    @error('dtes') <span class="error">{{ $message }}</span> @enderror

</form>