<div>
    @include('finance.payments.partials.nav')
    <h3 class="mb-3">Cargar archivo de TGR con reporte de de Pagos de TGR a Proveedores</h3>

    @include('layouts.bt5.partials.flash_message')

    <form wire:submit.prevent="upload">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <div class="input-group mb-3">            
            <input type="file" class="form-control" id="dte_file" wire:model="tgrs" accept=".xls">            
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar Archivo
            </button>
        </div>
        <span class="form-text text-muted">Archivo xls de reporte de TGR</span>
        @error('dtes') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror
    </form>
</div>
