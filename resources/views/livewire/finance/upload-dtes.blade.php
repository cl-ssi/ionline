<form wire:submit.prevent="upload">

    @include('finance.payments.partials.nav')    

    <h3 class="mb-3">Cargar archivo de Acepta con reporte de DTEs</h3>

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="dte_file" wire:model="dtes">
            <label class="custom-file-label" for="dte_file" data-browse="Examinar">{{ optional($dtes)->getClientOriginalName() }}</label>
            <small id="emailHelp" class="form-text text-muted">Archivo xls de reporte de acepta, máximo 2mb.</small>
        </div>
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"> <i class="fas fa-fw fa-upload"></i> Cargar Archivo</button>
        </div>
    </div>

    @error('dtes') <span class="error">{{ $message }}</span> @enderror

</form>