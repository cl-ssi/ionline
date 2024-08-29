<div>
    @include('finance.payments.partials.nav')
    <h3 class="mb-3">Cargar archivo de SII con reporte de BHE recibidas</h3>

    <form wire:submit="upload">

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div class="text-muted small">

        Servicios Online -> 
        Boletas de honorarios electrónicas -> 
        Emisor de boletas -> 
        Consulta sobre boletas de honorarios electrónicas -> 
        Consulta dobre boletas recibidas -> 
        Consultar por Mes
    </div>

    <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="bhe_file" wire:model.live="bhe">
            <label class="custom-file-label" for="bhe_file" data-browse="Examinar">{{ optional($bhe)->getClientOriginalName() }}</label>
            <small id="Help" class="form-text text-muted">Archivo xls de reporte de acepta, máximo 2mb.</small>
        </div>
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"> <i class="fas fa-fw fa-upload"></i> Cargar Archivo</button>
        </div>
    </div>

        @error('bhe') <span class="error">{{ $message }}</span> @enderror
    </form>

</div>