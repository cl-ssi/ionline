<form wire:submit="subir">

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
        <input class="form-control" type="file" id="dte_file" wire:model.live="dtes">
        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"> <i class="fas fa-fw fa-upload"></i> Cargar Archivo</button>
    </div>
    <small id="emailHelp" class="form-text text-muted">Archivo xls de reporte de acepta, máximo 2mb.</small>
    @error('dtes') <span class="error">{{ $message }}</span> @enderror

</form>